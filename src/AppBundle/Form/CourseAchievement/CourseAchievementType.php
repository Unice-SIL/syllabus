<?php

namespace AppBundle\Form\CourseAchievement;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CourseAchievementType
 * @package AppBundle\Form\CourseAchievement
 */
class CourseAchievementType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $syllabusEntityManager;

    /**
     * CourseAchievementType constructor.
     * @param EntityManager $syllabusEntityManager
     */
    public function __construct()
    {
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
            ]);
    }
}