<?php

namespace App\Controller\Admin;

use App\Entity\NaturalPerson;
use App\Entity\LegalPerson;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class LegalPersonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LegalPerson::class;
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
            ->setPageTitle('index', 'Liste des structures')
            ->setPageTitle('new', 'Ajouter une structure')
            ->setPageTitle('edit', 'Modifier une structure')
            ->setPageTitle('detail', 'Détails de la structure')
            ->renderContentMaximized()
            ;
    }
    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name', 'Nom de la structure');
        $siren = TextField::new('siren');
        $tradeAndCompagnyRegister = TextField::new('tradeAndCompagnyRegister', 'Raison social');
        $registerCapital = MoneyField::new('registerCapital', 'Capital social')
            ->setCurrency('EUR');
        $companyForm = TextField::new('companyForm', 'Forme');
        $isTenant = BooleanField::new('isTenant');
        $mainRepresentative = AssociationField::new('mainRepresentative', '1er représentant');
        $secondRepresentative = AssociationField::new('secondRepresentative', '2ème représentant');
        $email = EmailField::new('email', 'Email');
        $telephone = TelephoneField::new('telephone', 'Telephone1');
        $telephone2 = TelephoneField::new('telephone2', 'Telephone2');
        $address = ArrayField::new('addresses');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $siren, $tradeAndCompagnyRegister, $registerCapital, $companyForm,];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [
                FormField::addPanel('Informations de la structure'), $name, $siren,
                $tradeAndCompagnyRegister, $registerCapital, $companyForm, $email, $telephone, $telephone2,
                $mainRepresentative, $secondRepresentative, $address,
            ];
        } elseif (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
            return [$name, $siren, $tradeAndCompagnyRegister, $registerCapital, $companyForm, $isTenant,
                $email, $telephone, $telephone2,$mainRepresentative, $secondRepresentative, $address,
            ];
        }
    }
}
