<?php

namespace AppBundle\Form\CourseInfo\Evaluation;

use AppBundle\Entity\CourseInfo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EvaluationType
 * @package AppBundle\Form\CourseInfo\Evaluation
 */
class SpecificationsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mccAdvice', CKEditorType::class, [
            'label' => 'Description',
            'required' => false,
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseInfo::class
        ]);
    }
}