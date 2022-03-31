<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Category')
            ->setEntityLabelInPlural('Categories')   
            ->setPageTitle(Crud::PAGE_INDEX, 'Categories')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Categorie')
            ->setPageTitle(Crud::PAGE_NEW, 'Nouvelle Catégorie')
            ->setPageTitle(Crud::PAGE_EDIT, 'Modifier la Catégorie')
            ->setDefaultSort(['title' => 'ASC']);
    }
    
    public function configureActions(Actions $actions): Actions
    {
       
        return $actions
        
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
            return $action->setIcon('fa fa-plus-circle')->setLabel('Nouvelle Catégorie');
        })
        ->update(Crud::PAGE_INDEX, Action::DELETE, function(Action $action){
            return $action->setIcon('fa fa-trash')->setLabel('Supprimer');
        })
        ->update(Crud::PAGE_INDEX, Action::EDIT, function(Action $action){
            return $action->setIcon('fa fa-edit')->setLabel('Modifier');
        })
        ->add(Crud::PAGE_NEW, Action::INDEX)
        ->update(Crud::PAGE_NEW, Action::INDEX, function(Action $action){
            return $action->setIcon('fa fa-list')->setLabel('Retour à la liste');
        })
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function(Action $action){
            return $action->setIcon('fa fa-check')->setLabel('Valider');
        })
        ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
        ->add(Crud::PAGE_EDIT, Action::INDEX)
        ->update(Crud::PAGE_EDIT, Action::INDEX, function(Action $action){
            return $action->setIcon('fa fa-list')->setLabel('Retour à la liste');
        })
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function(Action $action){
            return $action->setLabel('Valider et continuer d\'éditer');
        })
        ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)
        ->update(Crud::PAGE_DETAIL, Action::DELETE, function(Action $action){
            return $action->setIcon('fa fa-trash')->setLabel('Supprimer');
        })
        ->update(Crud::PAGE_DETAIL, Action::EDIT, function(Action $action){
            return $action->setIcon('fa fa-edit')->setLabel('Modifier');
        })
        
        
        ;

        
         
    }

    //actions on index page
    public function createCategory(AdminContext $context)
    {
        $category = $context->getEntity()->getInstance();

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title')
                ->setLabel('Nom de la catégorie'),
        ];
    }
    
}
