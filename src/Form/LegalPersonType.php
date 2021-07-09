<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Associate;
use App\Entity\Executive;
use App\Entity\LegalPerson;
use App\Entity\NaturalPerson;
use App\Entity\OtherParticipant;
use App\Entity\Structure;
use App\Form\AddressType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegalPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('siren', TextType::class)
            ->add('tradeAndCompagnyRegister')
            ->add('registerCapital')
            ->add('companyForm', TextType::class)
            ->add('email', EmailType::class)
            ->add('telephone', TextType::class)
            ->add('telephone2', TextType::class)
            ->add('mainRepresentative', EntityType::class, [
                'class' => NaturalPerson::class,
                'choice_label' => 'lastname',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false,
            ])
            ->add('secondRepresentative', EntityType::class, [
                'class' => NaturalPerson::class,
                'choice_label' => 'lastname',
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
            ->add('executive', ExecutiveType::class)

            ->add('structure', EntityType::class, [
                'class' => Structure::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label' => false,
                'attr' => ['class' => 'd-none'],
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LegalPerson::class,
        ]);
    }
}
