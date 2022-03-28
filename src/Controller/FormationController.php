<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Lesson;
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

    #[Route('/suivre-formation/{slug}', name: 'formation')]
    public function show($slug): Response
    {
        
        $formation = $this->entityManager->getRepository(Formation::class)->findOneBySlug($slug);

        // Find ID formation
        $id_formation = $formation->getId();
        $section = $this->entityManager->getRepository(Section::class)->findOneByFormation($id_formation);

        // Find ID section
        $id_section = $section->getId();
        $lessons = $this->entityManager->getRepository(Lesson::class)->findBy(['section' => $id_section]);

        if (!$formation) {
            return $this->redirectToRoute('app_formation');
        }

        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'section' => $section,
            'lessons' => $lessons,
        ]);
    }
}
