<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
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
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $produits = $this->getDoctrine()->getRepository(Produit::class)->findBy([]);
        return $this->render(
            'accueil/index.html.twig',
            ['produits' => $produits]
        );
    }
    /**
     * Ajout de produits avec ajax (doit être admin pour ajouter)
     * @Route("/addcommande", name="addcommande")
     */
    public function addCommande(Request $request, ProduitRepository $produitRepository): Response
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            if ($request->get('commande')) {
                $user = $this->getUser();
                $commande_qte = $request->get('commande');
                $prix = 0;

                $entityManager = $this->getDoctrine()->getManager();

                $commande = new Commande();
                $commande->setCommandeUser($user);

                $entityManager->persist($commande);

                foreach ($commande_qte as $key => $val) {
                    $produit = $produitRepository->findProduitById($key);

                    $commandeProduit = new CommandeProduit();
                    $commandeProduit->setCommande($commande);
                    $commandeProduit->setProduit($produit);
                    $commandeProduit->setQteProduit($val);
                    $commandeProduit->setPrixProduit($produit->getPrix() * $val);

                    $prix += $produit->getPrix() * $val;

                    $entityManager->persist($commandeProduit);

                    $commande->addCommandeProduit($commandeProduit);
                }

                $commande->setPrix($prix);

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
