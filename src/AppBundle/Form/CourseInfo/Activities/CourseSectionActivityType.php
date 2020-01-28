<?php

namespace AppBundle\Form\CourseInfo\Activities;

use AppBundle\Entity\CourseSectionActivity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ActivityType
 * @package AppBundle\Form\CourseInfo\Activities
 */
class CourseSectionActivityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', TextType::class, [
                'label' => "Description de l'activité"
            ])
            ->add('evaluationRate', CheckboxType::class, [
                'label' => "Evaluable",
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseSectionActivity::class,
            'allow_extra_fields' => true
        ]);
    }
}