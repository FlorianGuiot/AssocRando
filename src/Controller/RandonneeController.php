<?php

namespace App\Controller;

use App\Repository\RandonneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Randonnee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class RandonneeController extends AbstractController
{
    #[Route('/randonnee', name: 'app_randonnee')]
    public function index(ManagerRegistry $doctrine): Response
    {   
        $recherche = null;

        if(isset($_POST['recherche'])){

            
            //Récupère toutes les randonnées disponibles
            $entityManager = $doctrine->getManager();
            $lesRandonnees = $entityManager->getRepository(Randonnee::class)->findByLibelle($_POST['recherche']);


            $recherche = $_POST['recherche'];

        }else{

            //Récupère toutes les randonnées disponibles
            $entityManager = $doctrine->getManager();
            $lesRandonnees = $entityManager->getRepository(Randonnee::class)->findRandonnee();
            // $lesRandonnees = $doctrine->getRepository(Randonnee::class)->findAll();

        }
        

        return $this->render('randonnee/index.html.twig', [
            'controller_name' => 'RandonneeController',
            'lesRandonnees' => $lesRandonnees,
            'recherche' => $recherche
        ]);
    }



    #[Route('/randonnee/{id}', name: 'show_randonnee')]
    public function randoInfo($id,ManagerRegistry $doctrine): Response
    {   

        $entityManager = $doctrine->getManager();
        $laRandonnee = $entityManager->getRepository(Randonnee::class)->find($id);
        $lesSessions = $laRandonnee->getLesSessions();
        

        return $this->render('randonnee/randonnee.html.twig', [
            'controller_name' => 'RandonneeController',
            'laRandonnee' => $laRandonnee,
            'lesSessions' => $lesSessions 
        ]);
    }


    #[Route('/randonnee/create', name: 'create_randonnee')]
    public function createRandonnee(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();


        $randonnee = new Randonnee();
        $randonnee->setLibelle('Le chemin de steevenson');
        $randonnee->setDureeMinutes(60);


        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($randonnee);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Nouvelle randonne sauvegardée avec l\'id '.$randonnee->getId());
    }
    
}
