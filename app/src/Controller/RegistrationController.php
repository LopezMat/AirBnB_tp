<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{

    // #[Route('/formulairesInscription', name: 'formRegister', methods: ['GET'])]
    // public function formRegister()
    // {
    //     return $this->render('home/register.html.twig');
    // }

    #[Route('/register', name: 'formRegister', methods: ['GET', 'POST'])]
    public function register(UserRepository $userRepository, Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {


        $user = new User();

        // $form = $this->createForm(RegistrationFormType::class, $user);
        // $form->handleRequest($request);
        if ($request->isMethod('POST')) {

            if ($request->request->get('password') == $request->request->get('confirm_password')) {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $request->request->get('password')
                    )
                );
            } else {
                return new Response('Les mots de passe ne sont pas identiques');
            }

            $name = $request->request->get('nom');
            $user->setNom($name);
            $firstName = $request->request->get('prenom');
            $user->setPrenom($firstName);
            $email = $request->request->get('email');
            $user->setEmail($email);
            $user->setIsActive(true);
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', []);
    }


    // if ($form->isSubmitted() && $form->isValid()) {
    //     dd($request);

    //     $user->setPassword(
    //         $userPasswordHasher->hashPassword(
    //             $user,
    //             $form->get('plainPassword')->getData()
    //         )
    //     );

    //     $userRepository->save($user, true);


    //     return $userAuthenticator->authenticateUser(
    //         $user,
    //         $authenticator,
    //         $request
    //     );
    // }

    // return $this->render('registration/register.html.twig', [
    //     'registrationForm' => $form->createView(),
    // ]);
}
