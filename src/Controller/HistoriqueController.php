<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/historique")
 */
class HistoriqueController extends AbstractController
{
    /**
     * @Route(name="historique")
     */
    public function index()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        return $this->render('historique/index.html.twig');
    }

    /**
     * @Route("/findcommandeshistorique", name="findcommandeshistorique")
     */
    public function findCommandes(Request $request): Response
    {
        if ($this->getUser()) {
            if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
                $entityManager = $this->getDoctrine()->getManager();
                $commandes = $entityManager->getRepository(Commande::class)->findBy(['commande_user' => $this->getUser()->getId()]);

                $content = $this->renderView('historique/commandes.html.twig', [
                    'commandes' => $commandes,
                ]);

                return new JsonResponse([
                    'code' => 200,
                    'content' => $content
                ]);
            }
        }

        return new JsonResponse([
            'code' => 403,
            'message' => "Unauthorized"
        ]);
    }
}
