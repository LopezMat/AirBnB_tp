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
            "logements" => $this->logementRepo->findAll(),
            "types" => $this->typeRepo->findAll(),

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
}
