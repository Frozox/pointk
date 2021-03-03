<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Sodium\add;

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
        if(!$this->getUser()){
            return $this->redirectToRoute('login');
        }

        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('accueil');
        }

        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'registrationForm' => $this->createForm(RegistrationFormType::class, new User())->createView(),
            //produitForm
        ]);
    }

    /**
     * Ajout de produits avec ajax (doit être admin pour ajouter)
     * @Route("/addproduit", name="addproduit")
     */
    public function addProduit(Request $request)
    {

    }

    /**
     * Ajout d'utilisateurs avec ajax (doit être admin pour ajouter)
     * @Route("/adduser", name="adduser")
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        if($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $user = new User();
                $registrationForm = $this->createForm(RegistrationFormType::class, $user);
                $registrationForm->handleRequest($request);

                if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
                    $user->setRoles(
                        $registrationForm->get('roles')->getData()
                    );

                    $randomPassword =  rtrim(strtr(base64_encode(random_bytes(10)), '+/', '-_'), '=');

                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $randomPassword
                        )
                    );

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $userId = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()])->getId();

                    $urlConfirmation = $this->getParameter('pointk.domain_name') . $this->generateUrl(
                        'confirm_account',
                        [
                            'userId' => $userId,
                            'token' => $user->getConfirmationToken()
                        ]
                    );

                    $this->sendMailToUser($mailer, $registrationForm, $randomPassword, $urlConfirmation);

                    return new JsonResponse([
                        'code' => 200,
                        'message' => "Formulaire valide",
                        'id' => $userId,
                        'email' => $user->getEmail()
                    ]);
                }
                else if ($registrationForm->isSubmitted() && !$registrationForm->isValid()) {
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
     * Suppression de produits avec ajax (doit être admin pour supprimer)
     * @Route("/deleteproduit/{produit}", name="deleteproduit")
     */
    public function deleteProduit(Request $request, Produit $produit): Response
    {

    }

    /**
     * Suppression d'utilisateurs avec ajax (doit être admin pour supprimer, ne peut pas se supprimer sois même)
     * @Route("/deleteuser/{user}", name="deleteuser")
     */
    public function deleteUser(Request $request, User $user): Response
    {
        if($this->getUser() && $this->isGranted('ROLE_ADMIN')){
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                if($user != $this->getUser()){
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

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }

    /**
     * Rafraichit la liste des produits avec ajax (doit être admin pour rafraichir)
     * @Route("/refreshproduits", name="refreshproduits")
     */
    public function refreshProduitList(Request $request): Response
    {

    }

    /**
     * Rafraichit la liste des utilisateurs avec ajax (doit être admin pour rafraichir)
     * @Route("/refreshusers", name="refreshusers")
     */
    public function refreshUserList(Request $request): Response
    {
        if($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $entityManager = $this->getDoctrine()->getManager();
                $users = $entityManager->getRepository(User::class)->findAll();

                $content = $this->renderView(
                    'admin/user/user.html.twig',
                    [
                        'users' => $users
                    ]
                );

                return new JsonResponse([
                    'code' => 200,
                    'message' => "refresh user list",
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
     * Rafraichit la liste des commandes avec ajax (doit être admin pour rafraichir)
     * @Route("/refreshcommandes", name="refreshcommandes")
     */
    public function refreshCommandeList(Request $request): Response
    {

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
    private function sendMailToUser(\Swift_Mailer $mailer, FormInterface $form, String $randomPassword, String $urlConfirmation){
        $email = (new \Swift_Message('Bienvenu dans le Pointk ' . $form->get('nom')->getData()))
            ->setFrom('pointk.geeps@gmail.com')
            ->setTo($form->get('email')->getData())
            ->setBody(
                $this->renderView(
                    'email/userConfirmationRegisterEmail.twig',
                    [
                        'token',
                        'nom' => $form->get('nom')->getData(),
                        'telephone' => $form->get('telephone')->getData(),
                        'role' => $form->get('roles')->getData()[0],
                        'password' => $randomPassword,
                        'url_confirmation' => $urlConfirmation
                    ]
                ),
                'text/html'
            );
        $mailer->send($email);
    }
}
