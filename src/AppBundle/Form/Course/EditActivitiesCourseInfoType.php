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
            ]);

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