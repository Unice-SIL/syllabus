<?php

namespace AppBundle\Form\CourseInfo\Activities;

use AppBundle\Entity\Activity;
use AppBundle\Entity\ActivityMode;
use AppBundle\Entity\ActivityType;
use AppBundle\Entity\CourseSectionActivity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                    'data-width' => '100',
                    'data-height' => '40',
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
                    'data-width' => '100',
                    'data-height' => '40',
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
            ])
            ->add('activityType', ChoiceType::class, [
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

        $formModifier = function (FormInterface $form, ActivityType $activityType = null) {
            $modes = null === $activityType ? [] : $activityType->getActivityModes();

            $form->add('activityMode', ChoiceType::class, [
                'label' => "Mode d'enseignement",
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'placeholder' => false,
                'choices' => $modes,
                'choice_label' => function(ActivityMode $activityMode) {
                    return $activityMode->getLabel();
                },
                'data' => current($modes)
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getActivityType());
            });

        $builder->get('activityType')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $activityType = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $activityType);
            }
        );
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