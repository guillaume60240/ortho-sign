<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Video::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Vidéo')
            ->setEntityLabelInPlural('Vidéos')   
            ->setPageTitle(Crud::PAGE_INDEX, 'Vidéos')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Vidéo')
            ->setPageTitle(Crud::PAGE_NEW, 'Nouvelle Vidéo')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la vidéo')
            ->setDefaultSort(['title' => 'ASC']);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Titre'),
            TextareaField::new('commentary')
                ->setLabel('Commentaire'),
            BooleanField::new('published')
                ->setLabel('Visible'),
            TextField::new('falseResponseOne')
                ->setLabel('Réponse fausse 1')
                ->hideOnIndex(),
            TextField::new('falseResponseTwo')
                ->setLabel('Réponse fausse 2')
                ->hideOnIndex(),
            
        ];
    }
    
}
