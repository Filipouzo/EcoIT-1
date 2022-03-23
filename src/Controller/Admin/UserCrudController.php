<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('password')->hideOnIndex(),
            TextField::new('pseudo'),
            ImageField::new('photo')->setBasePath('assets/images')->setUploadDir('public/assets/images'),
            TextareaField::new('description'),
            ChoiceField::new('roles')->setChoices([
                'admin' => 'ROLE_ADMIN',
                'instructor' => 'ROLE_INSTRUCTOR',
            ])->allowMultipleChoices()
        ];
    }
    
}
