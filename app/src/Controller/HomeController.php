<?php

namespace App\Controller;

use App\Entity\Logement;
use App\Repository\TypeRepository;
use App\Repository\LogementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    private $logementRepo;
    private $typeRepo;

    public function __construct(LogementRepository $logementRepository, TypeRepository $typeRepository)
    {
        $this->logementRepo = $logementRepository;
        $this->typeRepo = $typeRepository;
    }

    #[Route('/', name: 'home', methods: ['GET'])]
    public function home()
    {
        $date = new \DateTime();
        return $this->render('home/home.html.twig', [
            "dateDuJour" => $date->format('y-m-d'),
            "logements" => $this->logementRepo->opti2(),
            "types" => $this->typeRepo->opti(),

        ]);
    }


    // #[Route('/formulairesInscription', name: 'formRegister', methods: ['GET'])]
    // public function formRegister()
    // {
    //     return $this->render('home/register.html.twig');
    // }

    #[Route('/addLogement/{id}', name: 'addLogement', methods: ['GET', 'POST'])]
    public function addLogement(int $id, Request $request, ManagerRegistry $managerRegistry)
    {

        return $this->render(
            'home/addLogement.html.twig',
            [
                "types" => $this->typeRepo->findAll(),

            ]
        );
    }

    #[Route('/mesLogements', name: 'mesLogements', methods: ['GET'])]
    public function mesLogements()
    {
        return $this->render('home/mesLogements.html.twig');
    }

    #[Route('/support', name: 'support', methods: ['GET'])]
    public function support()
    {
        return $this->render('home/support.html.twig');
    }

    #[Route('/detailLogement/{id}', name: 'detailLogement', methods: ['GET'])]
    public function detailLogement(int $id)
    {
        return $this->render('home/detailLogement.html.twig', [
            "logements" => $this->logementRepo->opti2(),
            "id" => $id
        ]);
    }

    #[Route('/reservation/{id}', name: 'reservation', methods: ['GET'])]
    public function reservation(int $id)
    {

        return $this->render('home/reservation.html.twig', [
            "logements" => $this->logementRepo->opti2(),
            "id" => $id
        ]);
    }
}
