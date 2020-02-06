<?php

namespace AppBundle\Form\CourseInfo\Activities;

use AppBundle\Entity\Activity;
use AppBundle\Entity\ActivityMode;
use AppBundle\Entity\ActivityType;
use AppBundle\Entity\CourseSectionActivity;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
use Symfony\Component\Validator\Constraints\NotBlank;

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

        $builder->add('description', TextType::class, [
            'label' => "Description de l'activité",
            'required' => false
        ])
            ->add('evaluationRate', NumberType::class, [
                'label' => "Coefficient",
                'required' => false,
                'label_attr' => ['class' => 'mr-2 my-auto']
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
            ->add('activityType', EntityType::class, [
                'class' => ActivityType::class,
                'label' => "Type d'activité",
                'multiple' => false,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) use ($activity) {
                    $qb = $er->createQueryBuilder('at');
                    $qb->andWhere(":activity MEMBER OF at.activities")
                        ->setParameter("activity", $activity)
                        ->orderBy('at.label', 'ASC');
                    return $qb;
                },
                'choice_label' => 'label'
            ]);

        $formModifier = function (FormInterface $form, ActivityType $activityType = null) {
            $form->add('activityMode', EntityType::class, [
                'class' => ActivityMode::class,
                'label' => "Mode d'enseignement",
                'multiple' => false,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) use ($activityType) {
                    $qb = $er->createQueryBuilder('am');
                    $qb->andWhere(":activityType MEMBER OF am.activityTypes")
                        ->setParameter("activityType", $activityType)
                        ->orderBy('am.label', 'ASC');
                    return $qb;
                },
                'choice_label' => 'label'
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
            'activity' => null
        ]);

        $resolver->setAllowedTypes('activity', Activity::class);
    }
}