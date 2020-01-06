<?php

namespace AppBundle\Form\CourseInfo\Presentation;


use AppBundle\Constant\Level;
use AppBundle\Entity\CourseInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneralType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period', TextType::class, [
                'label' => 'Période',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Tout le semestre'
                ]
            ])
            ->add('domain', TextType::class, [
                'label' => 'Domaine',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Chimie'
                ]
            ])
            ->add('languages', TextType::class, [
                'label' => 'Langues',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: allemand, russe'
                ]
            ])
            ->add('level', ChoiceType::class, [
                'label' => 'Niveau',
                'required' => false,
                'multiple' => false,
                'expanded' => true,
                'placeholder' => false,
                'choices' => Level::CHOICES
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class
        ]);
    }

}