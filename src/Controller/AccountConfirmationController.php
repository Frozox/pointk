<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountConfirmationController extends AbstractController
{
    /**
     * @Route("/confirm/{userId}/{token}", name="confirm_account")
     * @param $userId
     * @param $token
     * @return Response
     */
    public function index($userId, $token, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);

        if ($user != null) {
            if ($user->getConfirmationToken() != null) {
                if ($user->getConfirmationToken() == $token) {
                    $password = $request->get('password');
                    $confirmPassword = $request->get('confirmPassword');
                    $error = null;

                    if ($password && $confirmPassword) {
                        if ($password == $confirmPassword) {
                            $encodedPassword = $encoder->encodePassword($user, $password);

                            $user->setConfirmationToken(null);
                            $user->setPassword($encodedPassword);

                            $entityManager->flush();

                            return $this->redirectToRoute('login');
                        } else {
                            $error = 'Mot de passe invalide.';
                        }
                    }

                    return $this->render('security/confirm.html.twig', ['error' => $error]);
                }
            }
        }
        return $this->redirectToRoute('login');
    }
}
