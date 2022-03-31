<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PatientCrudController extends AbstractCrudController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Patient::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle(Crud::PAGE_NEW, 'Enregistrer un patient')
            ->setEntityLabelInSingular('Patient')
            ->setEntityLabelInPlural('Patients')
            ->setSearchFields(['email', 'refererFirstName', 'refererLastName', 'patientFirstName', 'patientLastName'])
            ->setDefaultSort(['patientLastName' => 'ASC', 'patientFirstName' => 'ASC'])
        ->setPageTitle(Crud::PAGE_EDIT, 'Modifier les informations')
        ->setPageTitle(Crud::PAGE_DETAIL, 'Détails du patient');
    }

    public function configureActions(Actions $actions): Actions
    {
        //Méthode pour générer le token après ajput d'un patient. N'apparait pas si le token est déjà générer
        $createToken = Action::new('createToken', 'Générer le lien', 'fa fa-check')
            ->linkToCrudAction('createToken')
            ->addCssClass('btn btn-success')
            ->displayIf(static function($entity) {
                return $entity->getToken() === null;
            });

        //Méthode pour envoyer le lien de connexion au patient après la génération du token
        $sendLinkToPatient = Action::new('sendLinkToPatient', 'Envoyer le lien', 'fa fa-check')
            ->linkToCrudAction('sendLinkToPatient')
            ->addCssClass('btn btn-success')
            ->displayIf(static function($entity) {
                return $entity->getToken();
            });
            
            
        $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-plus-circle')->setLabel('Nouveau Patient');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fa fa-trash')->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel('Modifier');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon('fa fa-eye')->setLabel('Détails');
            })
            ->add(Crud::PAGE_INDEX, $createToken)
            ->add(Crud::PAGE_INDEX, $sendLinkToPatient)
           
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fa fa-check')->setLabel('Valider');
            })
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->update(Crud::PAGE_NEW, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-home')->setLabel('Retour');
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
            ->add(Crud::PAGE_DETAIL, $createToken)
            ->add(Crud::PAGE_DETAIL, $sendLinkToPatient)
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel('Modifier');
            })
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->update(Crud::PAGE_EDIT, Action::INDEX, function (Action $action) {
                return $action->setIcon('fa fa-home')->setLabel('Retour à la liste');
            })
            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->reorder(Crud::PAGE_DETAIL, [Action::INDEX, Action::DELETE, Action::EDIT])
                ;
            return $actions;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           
            TextField::new('email')
                ->setLabel('Email'),
            TextField::new('refererLastName')
                ->setLabel('Nom de famille du référent')
                ->setTemplatePath('Admin/Patient/refererLastName.html.twig'),
            TextField::new('refererFirstName')
                ->setLabel('Prénom du référent')
                ->hideOnIndex()
                ->setTemplatePath('Admin/Patient/refererFirstName.html.twig'),
            TextField::new('patientLastName')
                ->setLabel('Nom de famille du patient'),
            TextField::new('patientFirstName')
                ->setLabel('Prénom du patient'), 
            TextField::new('token')
                ->setLabel('Mail envoyé')
                ->hideOnForm()
                ->setTemplatePath('Admin/Patient/token.html.twig'),       
        ];
    }


    public function createToken(AdminContext $context) 
    {
        $patient = $context->getEntity()->getInstance();
        $lastName = $patient->getPatientLastName();
        $firstName = $patient->getPatientFirstName();
        $mail = $patient->getEmail();
        $date = new \DateTime();
        $token = $lastName.$firstName.$mail.$date->format('Y-m-d H:i:s');
        $token = hash('sha256', $token);
        $patient->setToken($token);
        $this->entityManager->persist($patient);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin');
    }

    public function sendLinkToPatient(AdminContext $context)
    {
        dd($context);
    }
}
