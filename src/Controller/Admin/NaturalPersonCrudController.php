<?php

namespace App\Controller\Admin;

use App\Entity\NaturalPerson;
use App\Entity\LegalPerson;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use App\Repository\ContactRepository;
use App\Form\ContactType;
use App\Controller\Admin\ContactCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class NaturalPersonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NaturalPerson::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Voir détail');
            })
        ;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des membres')
            ->setPageTitle('new', 'Ajouter un membre')
            ->setPageTitle('edit', '<h2 class="text-center">Modifier un membre</h2>')
            ;
    }
    public function configureFields(string $pageName): iterable
    {
        $gender = TextField::new('gender', 'Genre');
        $firstname = TextField::new('firstname', 'Prénom');
        $lastname = TextField::new('lastname', 'Nom de famille');
        $dateOfBirth = DateField::new('dateOfBirth', 'Date de naissance');
        $placeOfBirth = TextField::new('placeOfBirth', 'Lieu de naissance');
        $email = EmailField::new('email', 'Email');
        $telephone = TelephoneField::new('telephone', 'Telephone1');
        $telephone2 = TelephoneField::new('telephone2', 'Telephone2');
        $address = ArrayField::new('addresses');
        if (Crud::PAGE_INDEX === $pageName) {
            return [$lastname, $firstname, ];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [
                FormField::addPanel('Identitée'), $gender, $firstname, $lastname, $dateOfBirth, $placeOfBirth,
                FormField::addPanel('Contact'), $email, $telephone, $telephone2,
                FormField::addPanel('Adresse'), $address,
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$gender, $firstname, $lastname, $dateOfBirth, $placeOfBirth,
            $email, $telephone, $telephone2, ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$gender, $firstname, $lastname, $dateOfBirth, $placeOfBirth, $email, $telephone, $telephone2, ];
        }
    }
}
