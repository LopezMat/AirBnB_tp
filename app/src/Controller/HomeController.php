<?php

namespace App\Controller;

use App\Repository\LogementRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $logementRepo;

    public function __construct(LogementRepository $logementRepository)
    {
        $this->logementRepo = $logementRepository;
    }

    #[Route('/', name: 'home', methods: ['GET'])]
    public function home()
    {
        $date = new \DateTime();
        return $this->render('home/home.html.twig', [
            "dateDuJour" => $date->format('y-m-d'),
        ]);
    }
}
