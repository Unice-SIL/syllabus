<?php


namespace AppBundle\Form;


use AppBundle\Entity\Course;
use AppBundle\Form\Subscriber\CriticalAchievementTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class CriticalAchievementType extends AbstractType
{
    private $criticalAchievementTypeSubscriber;

    public function __construct(CriticalAchievementTypeSubscriber $criticalAchievementTypeSubscriber)
    {
        $this->criticalAchievementTypeSubscriber = $criticalAchievementTypeSubscriber;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('courses', Select2EntityType::class, [
                'label' => 'admin.critical_achievement.form.course',
                'multiple' => true,
                'remote_route' => 'app_admin.course_autocompleteS3',
                'class' => Course::class,
                'text_property' => 'code',
                'language' => 'fr',
                'minimum_input_length' => 0,
                'required' => false
            ])
            ->addEventSubscriber($this->criticalAchievementTypeSubscriber);
    }
}