<?php

namespace App\Form;

use App\Entity\Rapport;
use App\Form\OffrirType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('motif')
            ->add('bilan')
            ->add('medecin')

            ->add('offrirs', CollectionType::class, [
                'entry_type' => OffrirType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false]
            ])

            ->add('motif', ChoiceType::class, [
                'choices' => [
                    'Demande du médecin' => 'Demande du médecin',
                    'Recommandation de confrère' => 'Recommandation de confrère',
                    'Visite annuelle' => 'Visite annuelle',
                    'Prise de contact' => 'Prise de contact',
                    'Installation nouvelle' => 'Installation nouvelle',
                    'Positif' => 'Positif',

                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
