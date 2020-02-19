<?php

namespace AppBundle\Form\CourseInfo\Activities;


use AppBundle\Entity\CourseSection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DuplicateCourseSection
 * @package AppBundle\Form\CourseInfo\Activities
 */
class DuplicateCourseSectionType extends AbstractType
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
            'data_class' => CourseSection::class
        ]);
    }
}