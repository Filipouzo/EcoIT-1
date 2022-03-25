<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Section;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class FormationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/formation', name: 'app_formation')]
    public function index(): Response
    {
        $formations = $this->entityManager->getRepository(Formation::class)->findAll();
        // $formations = $this->entityManager->getRepository(Section::class)->findAll();
        
        return $this->render('formation/index.html.twig', [
            'formations' => $formations
        ]);
    }
}
