<?php

namespace AppBundle\Form\Api;

use AppBundle\Entity\CourseSection;
use AppBundle\Form\Api\Type\ApiCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseSectionType extends ApiAbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildApiForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('title')
            ->add('description')
            ->add('position')
            ->add('courseSectionActivities', ApiCollectionType::class, [
                'entry_type' => CourseSectionActivityType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => false
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CourseSection::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_coursesection';
    }


}
