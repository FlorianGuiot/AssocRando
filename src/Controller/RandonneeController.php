<?php

namespace App\Controller;

use App\Repository\RandonneeRepository;
use App\Repository\SessionRandoRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Randonnee;
use App\Entity\SessionRando;
use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use DateTimeInterface;


class RandonneeController extends AbstractController
{
    #[Route('/', name: 'app_randonnee')]
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


        
        //Duree de la randonnee
        $minutes = $laRandonnee->getDureeMinutes() % 60;
        if( strlen((string) $minutes) == 1){
            
            $minutes = "0".$minutes;
        }
        $duree = floor($laRandonnee->getDureeMinutes() / 60) . "h" . $minutes;

        $erreur = "";
        $success = "";

        if(isset($_POST['btnSession'])){

            //Cherche la session dans la liste des sessions
            $i = 0;
            $laSession = null;
            while($i <= $lesSessions->count() - 1 && $laSession == null){
                if($lesSessions[$i]->getId() == $_POST['idSession']){
                    $laSession = $lesSessions[$i];
                }
                $i++;
            }

            //Verifie que la session existe bien.
            if($laSession != null){

                //Verifie qu'il reste des places pour la session
                if($laSession->getLesParticipants()->count() >= $laSession->getNbPlaces()){
                    $erreur = "Cette session a déja atteint le nombre maximal de randonneur.";
                }

            }else{
                $erreur = "Cette session n'existe plus.";
            }

            //Verifie si l'utilisateur est connecté.
            if(!$this->getUser()){
                $erreur = "Vous devez etre connecté pour vous inscrire.";
            }

            if($erreur == ""){
                
                if(!$laSession->estParticipant($this->getUser())){

                    $laSession->addLesParticipant($this->getUser());

                    $entityManager->persist($laSession);
                    $entityManager->flush();

                    $success = "Vous etes désormais inscrit pour cette session.";

                }else{

                    $erreur = "Vous etes déja inscrit pour cette session.";
                }
                
            }
            
        }

        return $this->render('randonnee/randonnee.html.twig', [
            'controller_name' => 'RandonneeController',
            'laRandonnee' => $laRandonnee,
            'lesSessions' => $lesSessions,
            'duree' => $duree,
            'erreur' => $erreur,
            'success' => $success
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
