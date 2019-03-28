<?php

namespace AppBundle\Form\CourseSectionActivity;

use AppBundle\Command\CourseSectionActivity\CourseSectionActivityCommand;
use AppBundle\Entity\Activity;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseSectionActivityType
 * @package AppBundle\Form\CourseSectionActivity
 */
class CourseSectionActivityType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $syllabusEntityManager;

    /**
     * CourseSectionActivityType constructor.
     * @param EntityManager $syllabusEntityManager
     */
    public function __construct(EntityManager $syllabusEntityManager)
    {
        $this->syllabusEntityManager = $syllabusEntityManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('activity', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'label',
                'attr' => [
                    'hidden ' => true
                ]
            ])
            ->add('evaluationRate', TextType::class, [
                'required' => false,
            ])
            ->add('evaluationTeacher', CheckboxType::class, [
                'required' => false,
                'label' => "l'enseignant"
            ])
            ->add('evaluationPeer', CheckboxType::class, [
                'required' => false,
                'label' => 'les pairs'
            ])
            ->add('order', HiddenType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseSectionActivityCommand::class,
        ]);
    }

    public function getName(){
        return CourseSectionActivityType::class;
    }
}