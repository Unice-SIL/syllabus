<?php

namespace AppBundle\Form\CourseInfo\Presentation;


use AppBundle\Constant\TeachingMode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TeachingModeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teachingMode', ChoiceType::class, [
                'label' => false,
                'expanded'  => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => false,
                'choices' => TeachingMode::CHOICES
            ])
            ->add('teachingCmClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'label' => 'h Cours Magistraux',
            ])
            ->add('teachingTdClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'label' => 'h Travaux Dirigés',
            ])
            ->add('teachingTpClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'label' => 'h Travaux Pratiques',
            ])
            ->add('teachingOtherClass', TextType::class, [
                'required' => false,
                'label' => 'Volume',
                'attr' => [
                    'data-teaching-mode' => 'class',
                    'placeholder' => 'Volume (H)'
                ]
            ])
            ->add('teachingOtherTypeClass', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'class',
                    'placeholder' => 'Type (Ex: Heures personnelles)'
                ]
            ])
            ->add('teachingCmHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Cours Magistraux',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Travaux Dirigés',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTpHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Travaux Pratiques',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherHybridClass', TextType::class, [
                'required' => false,
                'label' => 'h Autre (facultatif)',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherTypeHybridClass', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'hybrid',
                    'placeholder' => 'Ex: Heures personnelles'
                ]
            ])
            ->add('teachingCmHybridDist', TextType::class, [
                'required' => false,
                'label' => 'h Cours Magistraux',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridDist', TextType::class, [
                'required' => false,
                'label' => 'h Travaux Dirigés',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherHybridDist', TextType::class, [
                'required' => false,
                'label' => 'h Autre (facultatif)',
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherTypeHybridDistant', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'hybrid',
                    'placeholder' => 'Ex: Heures personnelles'
                ]
            ])
            ->add('teachingCmDist', TextType::class, [
                'required' => false,
                'label' => 'h Cours Magistraux',
            ])
            ->add('teachingTdDist', TextType::class, [
                'required' => false,
                'label' => 'h Travaux Dirigés',
            ])
            ->add('teachingOtherDist', TextType::class, [
                'required' => false,
                'label' => 'h Autre (facultatif)',
                'attr' => [
                    'data-teaching-mode' => 'class'
                ]
            ])
            ->add('teachingOtherTypeDist', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'class',
                    'placeholder' => 'Ex: Heures personnelles'
                ]
            ]);
    }
}