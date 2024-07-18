<?php

namespace App\Syllabus\Form\CourseInfo\Presentation;

use App\Syllabus\Entity\CourseTeacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RemoveTeacherType
 * @package App\Syllabus\Form\CourseInfo\Presentation
 */
class RemoveTeacherType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {}

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseTeacher::class,
            'csrf_token_id' => 'delete_teacher'
        ]);
    }
}