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
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.cm',
                ]
            ])
            ->add('teachingTdClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.td',
                ]
            ])
            ->add('teachingTpClass', TextType::class, [
                'required' => false,
                'disabled' => true,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.tp',
                ]
            ])
            ->add('teachingOtherClass', TextType::class, [
                'required' => false,
                'label' => 'Volume',
                'attr' => [
                    'data-teaching-mode' => 'class',
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.other_class'
                ]
            ])
            ->add('teachingOtherTypeClass', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'class',
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.type'
                ]
            ])
            ->add('teachingCmHybridClass', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.cm',
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridClass', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.td',
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTpHybridClass', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.tp',
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherHybridClass', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.other',
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherTypeHybridClass', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'hybrid',
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.type'
                ]
            ])
            ->add('teachingCmHybridDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.cm',
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.td',
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherHybridDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.other',
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingOtherTypeHybridDistant', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'hybrid',
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.type'
                ]
            ])
            ->add('teachingCmDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.cm',
                ]
            ])
            ->add('teachingTdDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.td',
                ]
            ])
            ->add('teachingOtherDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.other',
                    'data-teaching-mode' => 'class'
                ]
            ])
            ->add('teachingOtherTypeDist', TextType::class, [
                'required' => false,
                'label' => 'Type',
                'attr' => [
                    'data-teaching-mode' => 'class',
                    'placeholder' => 'app.presentation.form.teaching_mode.placeholder.teaching.type'
                ]
            ]);
    }
}