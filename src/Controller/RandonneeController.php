<?php

namespace App\Controller;

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
        //Récupère toutes les randonnées disponibles
        $lesRandonnees = $doctrine->getRepository(Randonnee::class)->findAll();

        return $this->render('randonnee/index.html.twig', [
            'controller_name' => 'RandonneeController',
            'lesRandonnees' => $lesRandonnees
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
