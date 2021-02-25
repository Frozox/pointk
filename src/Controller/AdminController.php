<?php

namespace App\Controller;

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
     * Ajout d'utilisateurs avec ajax (doit être admin pour ajouter)
     * @Route("/adduser", name="adduser")
     */
    public function AddUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
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

                    $this->SendMailToUser($mailer, $registrationForm, $randomPassword, $urlConfirmation);

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
        ], 403);
    }

    /**
     * Suppression d'utilisateurs avec ajax (doit être admin pour supprimer, ne peut pas se supprimer sois même)
     * @Route("/deleteuser/{user}", name="deleteuser")
     */
    public function DeleteUser(Request $request, User $user): Response
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
        ], 403);
    }

    public function RefreshUserList(Request $request): Response
    {
        //permet de raffraichir la liste d'utilisateur après l'ajout d'un nouvel utilisateur
    }

    /*
     * Récupère les erreurs d'un formulaire
     */
    private function getErrorsFromForm(FormInterface $form)
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
    private function SendMailToUser(\Swift_Mailer $mailer, FormInterface $form, String $randomPassword, String $urlConfirmation){
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
