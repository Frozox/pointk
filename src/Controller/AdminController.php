<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('login');
        }

        if(!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('accueil');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(
                $form->get('roles')->getData()
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

            $this->SendMailToUser($mailer, $form, $randomPassword, $urlConfirmation);
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'registrationForm' => $form->createView(),
        ]);
    }

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
