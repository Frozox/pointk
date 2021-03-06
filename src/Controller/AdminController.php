<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\EditProduitFormType;
use App\Form\EditUserFormType;
use App\Form\ProduitFormType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route(name="admin")
     */
    public function index(UserRepository $userRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('accueil');
        }

        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'registrationForm' => $this->createForm(RegistrationFormType::class, new User())->createView(),
            'produitForm' => $this->createForm(ProduitFormType::class, new Produit())->createView(),
            'editProduitForm' => $this->createForm(EditProduitFormType::class, new Produit())->createView(),
            'editUserForm' => $this->createForm(EditUserFormType::class, new User())->createView()
        ]);
    }

    /**
     * Ajout de produits avec ajax (doit être admin pour ajouter)
     * @Route("/addproduit", name="addproduit")
     */
    public function addProduit(Request $request)
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $produit = new Produit();
                $produitForm = $this->createForm(ProduitFormType::class, $produit);
                $produitForm->handleRequest($request);

                if ($produitForm->isSubmitted() && $produitForm->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($produit);
                    $entityManager->flush();

                    $imageFile = $produitForm->get('image')->getData();

                    $newFilename = $produit->getId() . '.' . $imageFile->guessExtension();
                    $fullFilePath = '/images/produits/' . $newFilename;
                    try {
                        $imageFile->move(
                            '../public/images/produits/',
                            $newFilename
                        );
                    } catch (FileException $e) {
                        throw $e;
                        // ... handle exception if something happens during file upload
                    }

                    $produit->setImage($fullFilePath);

                    $entityManager->persist($produit);
                    $entityManager->flush();

                    return new JsonResponse([
                        'code' => 200,
                        'message' => 'Formulaire valide'
                    ]);
                } else if ($produitForm->isSubmitted() && !$produitForm->isValid()) {
                    return new JsonResponse([
                        'code' => 400,
                        'message' => "Formulaire invalide",
                        'errors' => $this->getErrorsFromForm($produitForm)
                    ]);
                }
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized",
        ]);
    }

    /**
     * Ajout d'utilisateurs avec ajax (doit être admin pour ajouter)
     * @Route("/adduser", name="adduser")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $user = new User();
                $registrationForm = $this->createForm(RegistrationFormType::class, $user);
                $registrationForm->handleRequest($request);

                if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
                    $user->setRoles(
                        $registrationForm->get('roles')->getData()
                    );

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $userId = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()])->getId();

                    $urlConfirmation = $this->generateUrl(
                        'confirm_account',
                        [
                            'userId' => $userId,
                            'token' => $user->getConfirmationToken()
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    );

                    $this->sendMailToUser($mailer, $registrationForm, $urlConfirmation);

                    return new JsonResponse([
                        'code' => 200,
                        'message' => "Formulaire valide",
                        'id' => $userId,
                        'email' => $user->getEmail()
                    ]);
                } else if ($registrationForm->isSubmitted() && !$registrationForm->isValid()) {
                    return new JsonResponse([
                        'code' => 400,
                        'message' => "Formulaire invalide",
                        'errors' => $this->getErrorsFromForm($registrationForm)
                    ]);
                }
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized",
        ]);
    }

    /**
     * Editer les attributs d'un produit
     * @Route("/editproduit", name="editproduit")
     */
    public function editProduit(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {

                $entityManager = $this->getDoctrine()->getManager();
                $produit = $entityManager->getRepository(Produit::class)->findOneBy(['id' => $request->get('produit')]);

                $editProduitForm = $this->createForm(EditProduitFormType::class, $produit);
                $editProduitForm->handleRequest($request);

                if ($editProduitForm->isSubmitted() && $editProduitForm->isValid()) {
                    $imageFile = $editProduitForm->get('image')->getData();

                    if ($imageFile) {
                        $newFilename = $produit->getId() . '.' . $imageFile->guessExtension();

                        try {
                            $imageFile->move(
                                '../public/images/produits/',
                                $newFilename
                            );
                        } catch (FileException $e) {
                            throw $e;
                            // ... handle exception if something happens during file upload
                        }
                    }

                    $entityManager->flush();

                    return new JsonResponse([
                        'code' => 200,
                        'message' => 'Formulaire valide',
                        'image' => $editProduitForm->get('image')->getData()
                    ]);
                } else if ($editProduitForm->isSubmitted() && !$editProduitForm->isValid()) {
                    return new JsonResponse([
                        'code' => 400,
                        'message' => "Formulaire invalide",
                        'errors' => $this->getErrorsFromForm($editProduitForm)
                    ]);
                }
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /**
     * Editer les attributs d'un utilisateur
     * @Route("/edituser", name="edituser")
     */
    public function editUser(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {

                $entityManager = $this->getDoctrine()->getManager();
                $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $request->get('user')]);

                $editUserForm = $this->createForm(EditUserFormType::class, $user);
                $editUserForm->handleRequest($request);

                if ($editUserForm->isSubmitted() && $editUserForm->isValid()) {
                    $soldAdded = $editUserForm->get('addsolde')->getData();
                    $telephone = $editUserForm->get('telephone')->getData();

                    if ($soldAdded) {
                        if ($soldAdded > 0) {
                            $user->addSolde($soldAdded);
                        }
                    }

                    $user->setTelephone($telephone);

                    $entityManager->flush();

                    return new JsonResponse([
                        'code' => 200,
                        'message' => 'Formulaire valide',
                        'tel' => $editUserForm->get('telephone')->getData()
                    ]);
                } else if ($editUserForm->isSubmitted() && !$editUserForm->isValid()) {
                    return new JsonResponse([
                        'code' => 400,
                        'message' => "Formulaire invalide",
                        'errors' => $this->getErrorsFromForm($editUserForm)
                    ]);
                }
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /**
     * Suppression de produits avec ajax (doit être admin pour supprimer)
     * @Route("/deleteproduit", name="deleteproduit")
     */
    public function deleteProduit(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                if ($request->get('produit')) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $produit = $entityManager->getRepository(Produit::class)->findOneBy(['id' => $request->get('produit')]);

                    $filesystem = new Filesystem();

                    try {
                        if ($produit->getImage() != null) {
                            $filesystem->remove('../public' . $produit->getImage());
                        }
                    } catch (FileException $e) {
                        throw $e;
                    }

                    $entityManager->remove($produit);
                    $entityManager->flush();

                    return new JsonResponse([
                        'code' => 200,
                        'id' => $produit->getId(),
                        'delete' => true
                    ]);
                }
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /**
     * Suppression d'utilisateurs avec ajax (doit être admin pour supprimer, ne peut pas se supprimer sois même)
     * @Route("/deleteuser", name="deleteuser")
     */
    public function deleteUser(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                if ($request->get('user')) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $request->get('user')]);

                    if ($user != $this->getUser()) {
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->remove($user);
                        $entityManager->flush();

                        return new JsonResponse([
                            'code' => 200,
                            'id' => $user->getId(),
                            'delete' => true
                        ]);
                    }
                }
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /**
     * Suppression de commande avec ajax (doit être admin pour supprimer, ne peut pas se supprimer sois même)
     * @Route("/deletecommande", name="deletecommande")
     */
    public function deleteCommande(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                if ($request->get('commande')) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $commande = $entityManager->getRepository(Commande::class)->findOneBy(['id' => $request->get('commande')]);

                    //Remboursement
                    $user = $commande->getCommandeUser();
                    $user->addSolde($commande->getPrix());

                    $entityManager->remove($commande);
                    $entityManager->flush();

                    return new JsonResponse([
                        'code' => 200,
                        'id' => $commande->getId(),
                        'delete' => true
                    ]);
                }
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }


    /**
     * @Route("/findproduits", name="findproduits")
     */
    public function findProduitsToList(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $entityManager = $this->getDoctrine()->getManager();
                $produits = $entityManager->getRepository(Produit::class)->findAll();
                $content = $this->renderView('admin/produit/produit.html.twig', [
                    'produits' => $produits,
                ]);

                return new JsonResponse([
                    'code' => 200,
                    'content' => $content
                ]);
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /**
     * @Route("/findusers", name="findusers")
     */
    public function findUsersToList(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $entityManager = $this->getDoctrine()->getManager();
                $users = $entityManager->getRepository(User::class)->findAll();

                $content = $this->renderView('admin/user/user.html.twig', [
                    'users' => $users,
                ]);

                return new JsonResponse([
                    'code' => 200,
                    'content' => $content
                ]);
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /**
     * @Route("/findcommandes", name="findcommandes")
     */
    public function findCommandesToList(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $entityManager = $this->getDoctrine()->getManager();
                $commandes = $entityManager->getRepository(Commande::class)->findAll();

                $content = $this->renderView('admin/commande/commande.html.twig', [
                    'commandes' => $commandes,
                ]);

                return new JsonResponse([
                    'code' => 200,
                    'content' => $content
                ]);
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /*
     * Récupère les erreurs d'un formulaire
     */
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

    /*
     * Envoie un mail à un utilisateur avec les informations de son compte
     */
    private function sendMailToUser(\Swift_Mailer $mailer, FormInterface $form, string $urlConfirmation)
    {
        $email = (new \Swift_Message('Bienvenu dans le Pointk ' . $form->get('nom')->getData()))
            ->setFrom('pointk.geeps@gmail.com')
            ->setTo($form->get('email')->getData())
            ->setBody(
                $this->renderView('email/userConfirmationRegisterEmail.twig', [
                    'token',
                    'nom' => $form->get('nom')->getData(),
                    'telephone' => $form->get('telephone')->getData(),
                    'role' => $form->get('roles')->getData()[0],
                    'url_confirmation' => $urlConfirmation
                ]),
                'text/html'
            );
        $mailer->send($email);
    }
}
