<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            // Add LEARN ROLE 
            $user->setRoles(['ROLE_LEARN']);

            // Password encoder
            $password = $user->getPassword();
            $hashedPassword = $encoder->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            // Database recording
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
