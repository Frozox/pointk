<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RecoverPasswordController extends AbstractController
{
    /**
     * @Route("/recover", name="recover")
     */
    public function index(Request $request, UserRepository $userRepository, \Swift_Mailer $mailer): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        $info = null;
        $error = null;

        if ($request->get('email')) {
            $user = $userRepository->findOneBy(
                ['email' => $request->get('email')]
            );

            if ($user) {
                if ($user->getConfirmationToken() != null) {
                    $error = "Le compte n'a pas été validé.";
                } else {
                    $info = "Un email de confirmation a été envoyé.";
                    $user->addRecoverToken();

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->flush();

                    $userId = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()])->getId();

                    $url_recover = $this->generateUrl(
                        'recover_account',
                        [
                            'userId' => $userId,
                            'token' => $user->getRecoverToken()
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    );

                    $this->sendMailToUser($mailer, $url_recover, $user);
                }
            } else {
                $error = "Adresse Email inconnu.";
            }
        }

        return $this->render('security/recover.html.twig', ['error' => $error, 'info' => $info]);
    }

    /**
     * @Route("/recover/{userId}/{token}", name="recover_account")
     * @param $userId
     * @param $token
     * @return Response
     */
    public function recover_account($userId, $token, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);

        if ($user != null) {
            if ($user->getRecoverToken() != null) {
                if ($user->getRecoverToken() == $token) {
                    $password = $request->get('password');
                    $confirmPassword = $request->get('confirmPassword');
                    $error = null;

                    if ($password && $confirmPassword) {
                        if ($password == $confirmPassword) {
                            $encodedPassword = $encoder->encodePassword($user, $password);

                            $user->resetRecoverToken();
                            $user->setPassword($encodedPassword);

                            $entityManager->flush();

                            return $this->redirectToRoute('login');
                        } else {
                            $error = 'Mot de passe invalide.';
                        }
                    }

                    return $this->render('security/recoverFormulaire.html.twig', ['error' => $error]);
                }
            }
        }
        return $this->redirectToRoute('login');
    }

    /*
     * Envoie un mail à un utilisateur pour le changement de mot de passe
     */
    private function sendMailToUser(\Swift_Mailer $mailer, string $url_recover, User $user)
    {
        $email = (new \Swift_Message('Réinitialisation de mot de passe'))
            ->setFrom('pointk.geeps@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView('email/userRecoverEmail.html.twig', [
                    'token',
                    'nom' => $user->getNom(),
                    'url_recover' => $url_recover
                ]),
                'text/html'
            );
        $mailer->send($email);
    }
}
