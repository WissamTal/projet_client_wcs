<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Associate;
use App\Entity\Executive;
use App\Entity\LegalPerson;
use App\Entity\NaturalPerson;
use App\Entity\OtherParticipant;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NaturalPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender')
            ->add('firstname')
            ->add('lastname')
            ->add('dateOfBirth')
            ->add('placeOfBirth')
            ->add('email')
            ->add('telephone')
            ->add('telephone2')
            ->add('mainLegalPerson', EntityType::class, [
                'class' => LegalPerson::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false,
            ])
            ->add('addresses', CollectionType::class, [
                'entry_type' => AddressType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('structureMember', EntityType::class, [
                'class' => Structure::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label' => false,
                'attr' => ['class' => 'd-none'],
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NaturalPerson::class,
        ]);
    }
}
