<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $db = mysqli_connect('160.228.216.44:3306','annuaire','SuperPandasTeam91!','annuaire');

        $sql = "SELECT login FROM compte";
        $query = mysqli_query($db,$sql);
        $result = $query->fetch_all();
        
        var_dump($result);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
