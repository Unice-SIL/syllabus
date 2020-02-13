<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use AppBundle\Entity\Activity;
use AppBundle\Form\CourseEvaluationCt\CourseEvaluationCtType;
use AppBundle\Form\CourseSection\CourseSectionType;
use AppBundle\Repository\ActivityRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditActivitiesCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditActivitiesCourseInfoType extends AbstractType
{

    /**
     * @var EntityManager
     */
    private $activityRepository;

    /**
     * @var array
     */
    private $ctEvaluations = [];

    /**
     * CourseSectionType constructor.
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(
        ActivityRepositoryInterface $activityRepository
    )
    {
        $this->activityRepository = $activityRepository;

        // CT evaluations
        $this->ctEvaluations = $this->activityRepository->findByCriteria(
            ActivityType::EVALUATION,
            ActivityMode::EVAL_CT,
            null
        );
    }

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
                'error_bubbling' => false,
                'prototype_name' => '__section__'
            ])
            ->add('ctEvaluations', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->ctEvaluations,
                'choice_label' => 'label',
            ])
            ->add('evaluations', CollectionType::class, [
                'label' => false,
                'entry_type' => CourseEvaluationCtType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
                // Get data
                $data = $event->getData();
                // Sort section
                if(array_key_exists('sections', $data)){
                    $sections = array_values($data['sections']);
                    foreach ($sections as $i => $section){
                        $sections[$i]['position'] = $i+1;
                    }
                    $data['sections'] = $sections;
                }
                // Sort evaluations
                if(array_key_exists('evaluations', $data)){
                    $evaluations = array_values($data['evaluations']);
                    foreach ($evaluations as $i => $evaluation){
                        $evaluations[$i]['position'] = $i+1;
                    }
                    $data['evaluations'] = $evaluations;
                }
                //Set data
                $event->setData($data);
            });

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditActivitiesCourseInfoCommand::class,
            'allow_extra_fields ' => true,
        ]);
    }

    public function getName(){
        return EditActivitiesCourseInfoType::class;
    }
}