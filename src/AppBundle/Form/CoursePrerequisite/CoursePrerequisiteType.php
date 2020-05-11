<?php

namespace AppBundle\Form\CoursePrerequisite;

use AppBundle\Command\CoursePrerequisite\CoursePrerequisiteCommand;
use AppBundle\Entity\Course;
use AppBundle\Entity\CoursePrerequisite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

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
                'label' => 'app.prerequisites.form.prerequisite_description',
                'required' => false,
            ])
            ->add('courses', Select2EntityType::class, [
                'label' => 'app.prerequisites.form.prerequisite_courses',
                'multiple' => true,
                'remote_route' => 'app_admin.course_autocompleteS3',
                'class' => Course::class,
                'text_property' => 'code',
                'language' => 'fr',
                'minimum_input_length' => 0,
                'required' => false
            ])
            ->add('position', HiddenType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoursePrerequisite::class,
        ]);
    }

    public function getName(){
        return CoursePrerequisiteType::class;
    }
}