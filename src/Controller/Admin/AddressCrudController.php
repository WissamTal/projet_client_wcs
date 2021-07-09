<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

/**
 * @IsGranted("ROLE_SUPERADMIN")
 */
class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
            ->add(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setLabel('Voir détail');
            });
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('addressStreet', 'Rue'),
            TextField::new('addressComplement', 'Complement'),
            TextField::new('addressZip', 'CP'),
            TextField::new('addressCity', 'Ville'),
            CountryField::new('addressCountry', 'Pays'),
            ArrayField::new('legalPerson', 'Personne morale'),
            ArrayField::new('naturalPerson', 'Personne physique'),
        ];
    }
}
