<?php

namespace AppBundle\Form\CourseEvaluationCt;

use AppBundle\Command\CourseEvaluationCt\CourseEvaluationCtCommand;
use AppBundle\Entity\Activity;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseEvaluationCtType
 * @package AppBundle\Form\CourseEvaluationCt
 */
class CourseEvaluationCtType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $syllabusEntityManager;

    /**
     * CourseSectionActivityType constructor.
     * @param EntityManager $syllabusEntityManager
     */
    /*public function __construct(EntityManager $syllabusEntityManager)
    {
        $this->syllabusEntityManager = $syllabusEntityManager;
    }*/

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('activity', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'label',
                'attr' => [
                    'hidden ' => true
                ]
            ])
            ->add('evaluationRate', TextType::class, [
                'required' => true,
            ])
            ->add('order', HiddenType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseEvaluationCtCommand::class,
        ]);
    }

    public function getName(){
        return CourseEvaluationCtType::class;
    }
}