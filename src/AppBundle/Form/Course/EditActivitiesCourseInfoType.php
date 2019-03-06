<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Form\CourseSection\CourseSectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditActivitiesCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditActivitiesCourseInfoType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sections', CollectionType::class, [
                'label' => false,
                'entry_type' => CourseSectionType::class,
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
            'data_class' => EditActivitiesCourseInfoCommand::class,
        ]);
    }
}