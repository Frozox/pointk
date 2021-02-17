<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountConfirmationController extends AbstractController{
    /**
     * @Route("/confirm/{userId}/{token}", name="confirm_account")
     * @param $userId
     * @param $token
     * @return Response
     */
    public function index($userId, $token): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);

        if($user != null){
            if($user->getConfirmationToken() != null){
                if($user->getConfirmationToken() == $token){
                    $user->setConfirmationToken(null);

                    $entityManager->persist($user);
                    $entityManager->flush();;

                    return $this->redirectToRoute('login');
                }
            }
        }
        return $this->render('security/confirm.html.twig');
    }
}