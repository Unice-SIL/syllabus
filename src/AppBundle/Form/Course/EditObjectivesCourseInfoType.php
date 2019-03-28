<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Form\CourseAchievement\CourseAchievementType;
use AppBundle\Form\CoursePrerequisite\CoursePrerequisiteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditObjectivesCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditObjectivesCourseInfoType extends AbstractType
{

    /**
     * EditObjectivesCourseInfoType constructor.
     */
    public function __construct(
    )
    {
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('achievements', CollectionType::class, [
                'label' => false,
                'entry_type' => CourseAchievementType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('prerequisites', CollectionType::class, [
                'label' => false,
                'entry_type' => CoursePrerequisiteType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('tutoring', CheckboxType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                ]
            ])
            ->add('tutoringTeacher', CheckboxType::class, [
                'required' => false,
                'label' => "Avec tuteur enseignant"
            ])
            ->add('tutoringStudent', CheckboxType::class, [
                'required' => false,
                'label' => "Avec tuteur étudiant"
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditObjectivesCourseInfoCommand::class,
            'allow_extra_fields ' => true,
        ]);
    }

    public function getName(){
        return EditObjectivesCourseInfoType::class;
    }
}