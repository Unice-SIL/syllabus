<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Form\CourseTeacher\CourseTeacherType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditPresentationCourseInfoType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period', TextType::class, [
                'label' => 'Period',
                'required' => false,
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Summary',
                'required' => false,
            ])
            ->add('teachingMode', ChoiceType::class, [
                'label' => 'Teaching mode',
                'expanded'  => true,
                'multiple' => false,
                'choices' => [
                    'Classroom' => 'class',
                    'Hybrid' => 'hybrid'
                ]
            ])
        ->add('teachers', CollectionType::class, [
            'entry_type' => CourseTeacherType::class,
            'entry_options' => [
                'label' => false,
            ],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditPresentationCourseInfoCommand::class
        ]);
    }
}