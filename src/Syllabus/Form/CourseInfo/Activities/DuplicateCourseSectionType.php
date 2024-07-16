<?php

namespace App\Syllabus\Form\CourseInfo\Activities;


use App\Syllabus\Entity\CourseSection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DuplicateCourseSection
 * @package App\Syllabus\Form\CourseInfo\Activities
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
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseSection::class,
            'csrf_token_id' => 'duplicate_section'
        ]);
    }
}