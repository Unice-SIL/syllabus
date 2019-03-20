<?php

namespace AppBundle\Form\CourseSection;

use AppBundle\Command\CourseSection\CourseSectionCommand;
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
    private $distantActivities = [];

    /**
     * CourseSectionType constructor.
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(
        ActivityRepositoryInterface $activityRepository
    )
    {
        $this->activityRepository = $activityRepository;

        // Class activities
        $this->classActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::CLASSROOM,
            null,
            null
        );
        /*
        foreach ($classActivities as $classActivity){
            $this->classActivities[$classActivity->getLabel()] = $classActivity->getId();
        }
        */

        // Class activities
        $this->distantActivities = $this->activityRepository->findByCriteria(
            ActivityType::ACTIVITY,
            ActivityMode::DISTANT,
            null,
            null
        );
        /*
        foreach ($distantActivities as $distantActivity){
            $this->distantActivities[$distantActivity->getLabel()] = $distantActivity->getId();
        }
        */
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
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
            ])
            /*
            ->add('classActivities', ChoiceType::class, [
                'label' => false,
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
                'choices' => $this->classActivities,

            ])
            */
            ->add('classActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->classActivities,
                'choice_label' => 'label',
            ])
            /*
            ->add('distantActivities', ChoiceType::class, [
                'label' => false,
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
                'choices' => $this->distantActivities,

            ])
            */
            ->add('distantActivities', EntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Activity::class,
                'choices' => $this->distantActivities,
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