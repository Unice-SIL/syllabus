<?php

namespace AppBundle\Form\CoursePrerequisite;

use AppBundle\Command\CoursePrerequisite\CoursePrerequisiteCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CoursePrerequisiteType
 * @package AppBundle\Form\CourseAchievement
 */
class CoursePrerequisiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('order', HiddenType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoursePrerequisiteCommand::class,
        ]);
    }

    public function getName(){
        return CoursePrerequisiteType::class;
    }
}