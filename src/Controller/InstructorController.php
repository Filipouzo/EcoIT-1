<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InstructorType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class InstructorController extends AbstractController
{
    #[Route('/instructor', name: 'app_instructor')]
    public function index(SluggerInterface $slugger, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();

        $form = $this->createForm(InstructorType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $user = $form->getData();

        //File upload
        $file = $form['photo']->getData();
        $fileOriginalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileSafeName = $slugger->slug($fileOriginalName);
        $fileNewName = $fileSafeName.'-'.uniqid().'.'.$file->guessExtension();
        $file->move($this->getParameter('directory'), $fileNewName);
        $user->setPhoto($fileNewName);

        //Password encoder
        $password = $user->getPassword();
        $hashedPassword = $encoder->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        //Database recording
        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        }
        return $this->render('instructor/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
