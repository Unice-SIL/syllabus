<?php


namespace App\Syllabus\Form\CourseInfo\CourseAchievement;


use App\Syllabus\Entity\CoursePrerequisite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveCoursePrerequisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {}

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CoursePrerequisite::class,
            'csrf_token_id' => 'delete_prerequisite'
        ]);
    }
}