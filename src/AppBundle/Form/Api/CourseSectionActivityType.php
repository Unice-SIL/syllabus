<?php

namespace AppBundle\Form\Api;

use AppBundle\Entity\CourseSectionActivity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseSectionActivityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('description')
            ->add('evaluationRate')
            ->add('evaluable')
            ->add('evaluationCt')
            ->add('evaluationTeacher')
            ->add('evaluationPeer')
            ->add('position')
            ->add('activity')
            ->add('activityType')
            ->add('activityMode')
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CourseSectionActivity::class,
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_coursesectionactivity';
    }


}
