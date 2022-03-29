<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Lesson;
use App\Entity\LessonCheck;
use App\Entity\Section;
use App\Repository\LessonCheckRepository;
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

    #[Route('/suivre-formation/{slug}/{id}/check', name: 'lesson_check')]
    public function check(Lesson $lesson, EntityManagerInterface $manager, LessonCheckRepository $checkRepository) : Response {
        
        $user = $this->getUser();

        if(!$user) return $this->json([
            'message' => 'NOOOOOOO', 
            'code' => 403
        ], 403);

        if($lesson->isCheckedByUser($user)) {
            $checked = $checkRepository->findOneBy([
                'lesson' => $lesson,
                'user' => $user
            ]);

            
            $manager->remove($checked);
            $manager->flush();

            return $this->json([
                'message' => 'OKKKKKK',
                'code' => 200,
                'checked' => false,
                'src' => "/assets/images/not-check.png"
            ], 200);
        }

        $checked = new LessonCheck();
        $checked->setLesson($lesson)
                ->setChecked(true)
                ->setUser($user);

        $manager->persist($checked);
        $manager->flush();

        return $this->json([
            'message' => 'ca marche frére', 
            'code' => 200,
            'checked' => true,
            'src' => "/assets/images/check.png"
        ], 200);
    }

    #[Route('/suivre-formation/{slug}/{id}', name: 'lesson_watch')]
    public function watch(Lesson $lesson, EntityManagerInterface $manager, LessonCheckRepository $checkRepository) : Response {
        $title = $lesson->getTitle();
        return $this->json([
            'lessonTitle' => $lesson->getTitle(), 
            'lessonVideo' => $lesson->getVideo(),
            'lessonExplanation' => $lesson->getExplanation(),
            'html' => "
            <div>' .$title. '</div>"
        ], 200);
    }
}
