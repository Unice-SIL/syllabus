<?php

namespace AppBundle\Form\CourseTeacher;

use AppBundle\Command\CourseTeacher\CourseTeacherCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseTeacherType
 * @package AppBundle\Form\Teacher
 */
class CourseTeacherType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('completeName', TextType::class, [
                'label' => 'Name',
                'disabled' => true,
            ])
            ->add('emailVisibility', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'value' => true,
            ])
            ->add('manager', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'value' => true,
            ])
            ->add('firstname', HiddenType::class, [
            ])
            ->add('lastname', HiddenType::class, [
            ])
            ->add('email', HiddenType::class, [
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseTeacherCommand::class
        ]);
    }

}