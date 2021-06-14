<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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
    /**
     * Ajout de produits avec ajax (doit être admin pour ajouter)
     * @Route("/addcommande", name="addcommande")
     */
    public function addCommande(Request $request) : Response
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            if ($request->get('prix')) {
                $prix = $request->get('prix');
                $commande = $request->get('commande');
                $entityManager = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                $solde = $user->getSolde();
                $newSolde = $solde - $prix;
                $user->setSolde($newSolde);
                $entityManager->flush();
                return new JsonResponse([
                    'code' => 200,
                    'solde' => $user->getSolde()
                ]);
            }
        }
    }
}
