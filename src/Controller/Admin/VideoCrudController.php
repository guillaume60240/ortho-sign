<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;

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

    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus-circle')->setLabel('Nouvelle Vidéo');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash')->setLabel('Supprimer la vidéo');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel('Modifier la vidéo');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')->setLabel('Détails de la vidéo');
            })
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->update(Crud::PAGE_NEW, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-list')->setLabel('Retour à la liste');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fa fa-check')->setLabel('Valider');
            })
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel('Modifier');
            })
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash')->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-home')->setLabel('Retour');
            })
            ->reorder(Crud::PAGE_DETAIL, [Action::INDEX, Action::DELETE, Action::EDIT])

            ;
            return $actions;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Titre'),
            AssociationField::new('category')
                ->setLabel('Catégorie'),
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
            TextField::new('file')
                ->setLabel('Vidéo')
                ->setFormType(VichFileType::class)
                ->onlyOnForms(),
            TextField::new('link')
                ->setLabel('Lien du fichier')
                ->hideOnForm(),         
        ];
    }
    
}
