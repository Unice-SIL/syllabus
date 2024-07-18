<?php

namespace App\Syllabus\Form\CourseInfo\Activities;

use App\Syllabus\Entity\CourseSection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RemoveSectionType
 * @package App\Syllabus\Form\CourseInfo\Activities
 */
class RemoveSectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseSection::class,
            'csrf_token_id' => 'delete_section'
        ]);
    }
}