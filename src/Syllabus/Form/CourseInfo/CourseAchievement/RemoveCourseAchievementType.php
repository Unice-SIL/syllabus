<?php


namespace App\Syllabus\Form\CourseInfo\CourseAchievement;


use App\Syllabus\Entity\CourseAchievement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RemoveCourseAchievementType
 * @package App\Syllabus\Form\CourseInfo\CourseAchievement
 */
class RemoveCourseAchievementType extends AbstractType
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
            'data_class' => CourseAchievement::class,
            'csrf_token_id' => 'delete_achievement'
        ]);
    }
}