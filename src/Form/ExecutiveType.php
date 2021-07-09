<?php

namespace App\Form;

use App\Entity\Executive;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExecutiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mandateStartdate')
            ->add('mandateEnddate')
            ->add('mandateType')
            ->add('mandateLimitations')
            ->add('legalPerson')
            ->add('naturalPerson')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Executive::class,
        ]);
    }
}
