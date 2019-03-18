<?php

namespace AppBundle\Form\CourseSection;

use AppBundle\Command\CourseSection\CourseSectionCommand;
use AppBundle\Entity\SectionType;
use AppBundle\Form\CourseSectionActivity\CourseSectionActivityType;
use Doctrine\ORM\EntityManager;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type',
                'required' =>true,
                'class' => SectionType::class,
                'choice_label' => 'label',
                'em' => $this->syllabusEntityManager,
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
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
            ''
        ]);
    }

    public function getName(){
        return CourseSectionType::class;
    }
}