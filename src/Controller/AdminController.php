<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Sodium\randombytes_uniform;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
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

            $randomPassword =  bin2hex(random_bytes(6));

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $randomPassword
                )
            );

            var_dump($randomPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            /*$email = (new Email())
                ->from('pointk@geeps.centralesupelec.fr')
                ->to($form->get('email')->getData())
                ->subject('Nouveau compte Pointk')
                ->text('Ceci est le contenu du mail et ele mdp: ' . $randomPassword)
                ->html('<p>Et tu peux également le mettre en html<br>mdp:' . $randomPassword . '</p>');
            $mailer->send($email);*/

            // encode the plain password
            /*$user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email*/

            //return $this->redirectToRoute('admin');
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'registrationForm' => $form->createView(),
        ]);
    }
}
