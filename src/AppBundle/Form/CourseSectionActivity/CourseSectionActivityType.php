<?php

namespace AppBundle\Form\CourseSectionActivity;

use AppBundle\Command\CourseSectionActivity\CourseSectionActivityCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
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
            ->add('id', HiddenType::class)
            ->add('title', HiddenType::class, [
                'label' => false,
                'disabled' => true,
            ])
            ->add('description', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "Préciser si nécessaire",
                ]
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