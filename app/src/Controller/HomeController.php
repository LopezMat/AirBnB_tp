<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\LogementRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/formulairesLogin', name: 'formLogin', methods: ['GET'])]
    public function formLogin()
    {
        return $this->render('home/login.html.twig');
    }

    #[Route('/formulairesInscription', name: 'formRegister', methods: ['GET'])]
    public function formRegister()
    {
        return $this->render('home/register.html.twig');
    }

    #[Route('/addLogement', name: 'addLogement', methods: ['GET', 'POST'])]
    public function addLogement()
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

    #[Route('/detailLogement{id}', name: 'detailLogement', methods: ['GET'])]
    public function detailLogement(int $id)
    {
        return $this->render('home/detailLogement.html.twig', [
            "logements" => $this->logementRepo->opti2(),
            "id" => $id
        ]);
    }
}
