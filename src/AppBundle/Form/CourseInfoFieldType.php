<?php

namespace AppBundle\Form;

use AppBundle\Entity\CourseInfoField;
use AppBundle\Form\Type\CustomCheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseInfoFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manuallyDuplication', CustomCheckboxType::class, [
                'label' => false,
            ])
            ->add('automaticDuplication', CustomCheckboxType::class, [
                'label' => false,
            ])
            ->add('import', CustomCheckboxType::class, [
                'label' => false,
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CourseInfoField::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_course_info_field';
    }


}
