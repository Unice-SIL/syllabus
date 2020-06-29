<?php

namespace AppBundle\Form\CourseInfo\Presentation;


use AppBundle\Constant\TeachingMode;
use AppBundle\Form\CourseInfo\Presentation\Subcriber\TeachingModeTypeSubscriber;
use AppBundle\Form\CourseInfo\Teaching\TeachingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('teachingCmHybridClass', TextType::class, [
                'required' => false,
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridClass', TextType::class, [
                'required' => false,
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTpHybridClass', TextType::class, [
                'required' => false,
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingCmHybridDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingTdHybridDist', TextType::class, [
                'required' => false,
                'attr' => [
                    'data-teaching-mode' => 'hybrid'
                ]
            ])
            ->add('teachingCmDist', TextType::class, [
                'required' => false
            ])
            ->add('teachingTdDist', TextType::class, [
                'required' => false
            ])
            ->add('teachings', CollectionType::class, [
                'entry_type' => TeachingType::class,
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype' => true,
                'label' => 'app.presentation.form.teaching_mode.additionnal'
            ])
        ;

        $builder->addEventSubscriber(new TeachingModeTypeSubscriber());
    }
}