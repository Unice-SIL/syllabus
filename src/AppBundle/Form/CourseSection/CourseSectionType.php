<?php

namespace AppBundle\Form\CourseSection;

use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use AppBundle\Entity\Activity;
use AppBundle\Entity\SectionType;
use AppBundle\Form\CourseSectionActivity\CourseSectionActivityType;
use AppBundle\Repository\ActivityRepositoryInterface;
use Doctrine\ORM\EntityManager;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseSectionType
 * @package AppBundle\Form\CourseSection
 */
class CourseSectionType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $activityRepository;

    /**
     * @var array
     */
    private $classActivities = [];

    /**
     * @var array
     */
    private $classTogetherActivities = [];

    /**
     * @var array
     */
    private $classGroupsActivities = [];

    /**
     * @var array
     */
    private $autonomyActivities = [];

    /**
     * @var array
     */
    private $autonomyIndividualActivities = [];

    /**
     * @var array
     */
    private $autonomyCollectiveActivities = [];

    /**
     * @var array
     */
    private $ccEvaluations = [];

    /**
     * CourseSectionType constructor.
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(
        ActivityRepositoryInterface $activityRepository
    )
    {
        $this->activityRepository = $activityRepository;

        // in class head activities
        $this->classActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::IN_CLASS,
            ActivityGroup::HEAD
        );

        // in class together activities
        $this->classTogetherActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::IN_CLASS,
            ActivityGroup::TOGETHER
        );

        // in class groups activities
        $this->classGroupsActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::IN_CLASS,
            ActivityGroup::GROUPS
        );

        // in autonomy head activities
        $this->autonomyActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::IN_AUTONOMY,
            ActivityGroup::HEAD
        );

        // in autonomy individual activities
        $this->autonomyIndividualActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::IN_AUTONOMY,
            ActivityGroup::INDIVIDUAL
        );

        // in autonomy collective activities
        $this->autonomyCollectiveActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::IN_AUTONOMY,
            ActivityGroup::COLLECTIVE
        );

        // CC evaluations
        $this->ccEvaluations = $this->activityRepository->findByCriteria(
            ActivityType::EVALUATION,
            ActivityMode::EVAL_CC,
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
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
            ])
            ->add('classActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->classActivities,
                'choice_label' => 'label',
            ])
            ->add('classGroupsActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->classGroupsActivities,
                'choice_label' => 'label',
            ])
            ->add('classTogetherActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->classTogetherActivities,
                'choice_label' => 'label',
            ])
            ->add('autonomyActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->autonomyActivities,
                'choice_label' => 'label',
            ])
            ->add('autonomyIndividualActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->autonomyIndividualActivities,
                'choice_label' => 'label',
            ])
            ->add('autonomyCollectiveActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->autonomyCollectiveActivities,
                'choice_label' => 'label',
            ])
            ->add('ccEvaluations', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->ccEvaluations,
                'choice_label' => 'label',
            ])
            ->add('activities', CollectionType::class, [
                'label' => false,
                'entry_type' => CourseSectionActivityType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false
            ])
            ->add('order', HiddenType::class, [
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseSectionCommand::class,
            'allow_extra_fields ' => true,
        ]);
    }

    public function getName(){
        return CourseSectionType::class;
    }
}