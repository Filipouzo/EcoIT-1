<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\FormationCrudController;
use App\Entity\Formation;
use App\Entity\Lesson;
use App\Entity\Section;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator) 
    {

    
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $urlAdmin = $this->adminUrlGenerator->setController(UserCrudController::class)->generateUrl();
        $urlInstructor = $this->adminUrlGenerator->setController(FormationCrudController::class)->generateUrl();

        $roles = $this->getUser()->getRoles();
        $role = $roles[0];
        
        if ($role === "ROLE_INSTRUCTOR") {
            return $this->redirect($urlInstructor);
        } else if ($role === 'ROLE_LEARN') {
            return $this->redirect('/account');
        } else {
            return $this->redirect($urlAdmin);
        }
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ecoit');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Utilisateurs')->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToDashboard('Utilisateurs', 'fas fa-user', User::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::section('Formations')->setPermission('ROLE_INSTRUCTOR');
        yield MenuItem::linkToCrud('Formations', 'fas fa-list-ul', Formation::class)->setPermission('ROLE_INSTRUCTOR');
        yield MenuItem::linkToCrud('Sections', 'fas fa-list-ul', Section::class)->setPermission('ROLE_INSTRUCTOR');
        yield MenuItem::linkToCrud('Leçons', 'fas fa-list-ul', Lesson::class)->setPermission('ROLE_INSTRUCTOR');
    }
}
