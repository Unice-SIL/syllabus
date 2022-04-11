<?php

namespace App\Syllabus\Form;

use App\Syllabus\Entity\Course;
use App\Syllabus\Form\Type\CustomCheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', null, [
                'label' => 'app.form.course.label.type'
            ])
            ->add('title', null, [
                'label' => 'app.form.course.label.title'
            ])
            ->add('code', null, [
                'label' => 'app.form.course.label.code'
            ])
            ->add('synchronized', CustomCheckboxType::class, [
                'label' => 'app.form.course.label.synchronized'
            ])
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Course::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_course';
    }
}
