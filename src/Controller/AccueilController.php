<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('login');
        }

        $produits = $this->getDoctrine()->getRepository(Produit::class)->findBy([]);
        return $this->render('accueil/index.html.twig',
            ['produits' => $produits]);
    }
}
