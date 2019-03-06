<?php

namespace AppBundle\Form\CourseSection;

use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Entity\SectionType;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
    private $syllabusEntityManager;

    /**
     * EditActivitiesCourseInfoType constructor.
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
            ->add('title', TextType::class, [
                'label' => 'Title',
                'required' => true,
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type',
                'required' =>true,
                'class' => SectionType::class,
                'choice_label' => 'label',
                'em' => $this->syllabusEntityManager,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
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
        ]);
    }
}