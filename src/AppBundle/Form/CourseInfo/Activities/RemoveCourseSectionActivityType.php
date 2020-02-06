<?php

namespace AppBundle\Form\CourseInfo\Activities;

use AppBundle\Entity\CourseSectionActivity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RemoveCourseSectionActivityType
 * @package AppBundle\Form\CourseInfo\Activities
 */
class RemoveCourseSectionActivityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseSectionActivity::class
        ]);
    }
}