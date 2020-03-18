<?php

namespace AppBundle\Form\CourseInfo\CourseAchievement;

use AppBundle\Entity\Course;
use AppBundle\Entity\CoursePrerequisite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class CoursePrerequisiteType
 * @package AppBundle\Form\CourseInfo\CourseAchievement
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
            ->add('courses', Select2EntityType::class, [
                'label' => 'Cours',
                'multiple' => true,
                'remote_route' => 'app_admin.course_autocompleteS3',
                'text_property' => 'title',
                'minimum_input_length' => 0,
                'required' => false,
                'by_reference' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoursePrerequisite::class
        ]);
    }
}