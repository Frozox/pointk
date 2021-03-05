<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $user = new User();
                $registrationForm = $this->createForm(RegistrationFormType::class, $user);
                $registrationForm->handleRequest($request);

                if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
                    $user->setRoles(
                        $registrationForm->get('roles')->getData()
                    );

                    $randomPassword = rtrim(strtr(base64_encode(random_bytes(10)), '+/', '-_'), '=');

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
     * Suppression de produits avec ajax (doit être admin pour supprimer)
     * @Route("/deleteproduit", name="deleteproduit")
     */
    public function deleteProduit(Request $request): Response
    {

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
     * @Route("/findproduits", name="findproduits")
     */
    public function findProduitsToList(Request $request): Response
    {

    }

    /**
     * @Route("/findusers", name="findusers")
     */
    public function findUsersToList(Request $request): Response
    {
        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                if ($request->get('page') != null) {
                    $search = $request->get('search');
                    $page = $request->get('page');
                    $limit = $this->getParameter('itemperpage');

                    $entityManager = $this->getDoctrine()->getManager();
                    $users = $entityManager->getRepository(User::class)->findBySearch($search, $page, $limit);
                    $nbusers = $entityManager->getRepository(User::class)->countBySearch($search);

                    $content = $this->renderView('admin/user/user.html.twig', [
                        'users' => $users,
                    ]);

                    $paginate = $this->renderView('paginate.html.twig', [
                        'page' => $page,
                        'nbusers' => $nbusers,
                        'limit' => $limit
                    ]);

                    return new JsonResponse([
                        'code' => 200,
                        'content' => $content,
                        'paginate' => $paginate,
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
     * @Route("/findcommandes", name="findcommandes")
     */
    public function findCommandesToList(Request $request): Response
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
    private function sendMailToUser(\Swift_Mailer $mailer, FormInterface $form, string $randomPassword, string $urlConfirmation)
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
                    'password' => $randomPassword,
                    'url_confirmation' => $urlConfirmation
                ]),
                'text/html'
            );
        $mailer->send($email);
    }
}
