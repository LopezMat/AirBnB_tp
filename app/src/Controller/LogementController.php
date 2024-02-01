<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Logement;
use App\Entity\Type;
use App\Entity\User;
use App\Form\Logement1Type;
use App\Repository\EquipementRepository;
use App\Repository\LogementRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\All;

#[Route('/logement')]
class LogementController extends AbstractController
{



    #[Route('/', name: 'app_logement_index', methods: ['GET'])]
    public function index(LogementRepository $logementRepository): Response
    {
        return $this->render('logement/index.html.twig', [
            'logements' => $logementRepository->findAll(),
        ]);
    }



    #[Route('/new/{id}', name: 'new_post', methods: ['POST'])]
    public function newPost(TypeRepository $typeRepository, Request $request, EntityManagerInterface $entityManager, User $user, EquipementRepository $equipementRepo)
    {
        $logement = new Logement();
        $logement->setUserId($user);
        $name = $request->request->get('name');
        $logement->setName($name);
        $couchage = $request->request->get('couchage');
        $logement->setCouchage($couchage);
        $prix = $request->request->get('prix');
        $logement->setPrix($prix);
        $taille = $request->request->get('taille');
        $logement->setTaille($taille);
        $description = $request->request->get('description');
        $logement->setDescription($description);
        $adresse = $request->request->get('adresse');
        $logement->setAdresse($adresse);
        $codePostal = $request->request->get('codePostal');
        $logement->setCodePostal($codePostal);
        $ville = $request->request->get('Ville');
        $logement->setVille($ville);
        $pays = $request->request->get('pays');
        $logement->setPays($pays);
        $typeId = $typeRepository->findBy([
            'label' => $request->request->get('type'),
        ]);
        $logement->addTypeId($typeId[0]);
        $equipementId = $equipementRepo->findBy([
            'label' => $request->request->get('equipement'),
        ]);
        $logement->addEquipementId($equipementId[0]);
        $imagePath = $request->files->get('imagePath');
        $logement->setImageFile($imagePath);
        $logement->setIsActive(true);


        $entityManager->persist($logement);
        $entityManager->flush();

        return $this->redirectToRoute('app_logement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/new/{id}', name: 'app_logement_new', methods: ['GET'])]
    public function new(TypeRepository $typeRepository, EquipementRepository $equipementRepo): Response
    {

        return $this->render('logement/new.html.twig', [
            'types' => $typeRepository->findAll(),
            'equipements' => $equipementRepo->findAll(),

        ]);
    }

    #[Route('/{id}', name: 'app_logement_show', methods: ['GET'])]
    public function show(Logement $logement): Response
    {
        return $this->render('logement/show.html.twig', [
            'logement' => $logement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_logement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Logement $logement, EntityManagerInterface $entityManager, TypeRepository $typeRepository, EquipementRepository $equipementRepo): Response
    {

        $form = $this->createForm(Logement1Type::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_logement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('logement/edit.html.twig', [
            'logement' => $logement,
            'form' => $form,
            'types' => $typeRepository->findAll(),
            'equipements' => $equipementRepo->findAll(),

        ]);
    }

    #[Route('/{id}', name: 'app_logement_delete', methods: ['POST'])]
    public function delete(Request $request, Logement $logement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $logement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($logement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logement_index', [], Response::HTTP_SEE_OTHER);
    }
}
