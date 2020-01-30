<?php

namespace AppBundle\Form\CourseInfo\Activities;

use AppBundle\Entity\Activity;
use AppBundle\Entity\ActivityType;
use AppBundle\Entity\CourseSectionActivity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
        /** @var Activity $activity */
        $activity = $options['activity'];
        $activityTypes = $activity->getActivityTypes()->toArray();
        $builder->add('description', TextType::class, [
                'label' => "Description de l'activité"
            ])
            ->add('evaluationRate', NumberType::class, [
                'label' => "Coefficient",
                'required' => false
            ])
            ->add('evaluable', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'type' => 'checkbox',
                    'data-toggle' => 'toggle',
                    'data-witdth' => '100',
                    'data-onstyle' => 'primary',
                    'data-offstyle' => 'secondary',
                    'data-style' => 'ios',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ]
            ])
            ->add('evaluationCt', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'type' => 'checkbox',
                    'data-toggle' => 'toggle',
                    'data-witdth' => '100',
                    'data-onstyle' => 'primary',
                    'data-offstyle' => 'secondary',
                    'data-style' => 'ios',
                    'data-on' => 'CT',
                    'data-off' => 'CC'
                ]
            ])
            ->add('evaluationTeacher', CheckboxType::class, [
                'label' => "Évaluation par les enseignants",
                'required' => false
            ])
            ->add('evaluationPeer', CheckboxType::class, [
                'label' => "Évaluation par les pairs",
                'required' => false
            ]);
        if (!empty($activityTypes))
        {
            $builder->add('activityType', ChoiceType::class, [
                'label' => "Type d'activité",
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'placeholder' => false,
                'choices' => $activityTypes,
                'choice_label' => function(ActivityType $activityType) {
                    return $activityType->getLabel();
                },
                'data' => current($activityTypes)
            ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseSectionActivity::class,
            'allow_extra_fields' => true,
            'activity' => Activity::class
        ]);

        $resolver->setAllowedTypes('activity', Activity::class);
    }
}