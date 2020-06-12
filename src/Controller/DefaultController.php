<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\dbcontroller;
use App\Entity\connexionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="connexion")
     */
    public function connexion(Request $request)
    {
        $db = new dbcontroller();
        $db->connectGeepsDb();
        $connexionType = new connexionType();
        $form = $this->createFormBuilder($connexionType)
            ->add('identifiant', TextType::class,[
                'label' => 'Entrez votre identifiant'
            ])
            ->add('motdepasse', PasswordType::class,[
                'label' => 'Entrez votre mot de passe'
            ])
            ->add('connexion', SubmitType::class)
            ->getForm()
            ;
        $form->handleRequest($request);

        $connexion=null;
        $user=null;

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $identifiant = $data->getIdentifiant();
            $motdepasse = $data->getMotdepasse();
            $connexion =  null;
            $user = null;

            var_dump('sucess');

            if($identifiant && $motdepasse)
            {
                $connexion = $db->connexionUtilisateur($identifiant,$motdepasse);
                $user = $db->getUtilisateurConnecte($identifiant,$motdepasse);
            }

            

            return $this->redirectToRoute('homepage',[
                'connexion' => $connexion,
                'user' => $user
            ]);

        }

        
        

        return $this->render('default/connexion.html.twig',[
            'form' => $form->createView(),
        ]);        
    }

    /**
     * @Route("/authentification",name="authentification", methods={"POST"})
     */
    public function authentification(Request $request)
    {
        $db = new dbcontroller();
        $db->connectGeepsDb();

        $identifiant = $request->$_POST['identifiant'];

        var_dump($identifiant);

        $connexion = $db->connexionUtilisateur('admgeeps','root');
        $user = $db->getUtilisateurConnecte('admgeeps','root');


        if($connexion['count(*)']){
            return $this->render('default/index.html.twig', [
                'controller_name' => 'DefaultController',
                'error'=>0,
                'utilisateur'=>$user
            ]);
        }else {
            return $this->render('default/index.html.twig', [
                'controller_name' => 'DefaultController',
                'error'=>-1
            ]);
        } 
    }

    /**
     * @Route("/home",name="homepage")
     */
    public function index(Request $request)
    {
        $db = new dbcontroller();

        $bdd = $db->connectGeepsDb();

        $user = $request->query->get('user');


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'user' => $user
        ]);
    }
}
