<?php


namespace AppBundle\Form\CourseInfo\CourseAchievement;


use AppBundle\Constant\CriticalAchievementRules;
use AppBundle\Entity\CourseCriticalAchievement;
use AppBundle\Entity\CriticalAchievement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class CourseCriticalAchievementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('criticalAchievement', Select2EntityType::class, [
                'label' => 'Aquis critique',
                'multiple' => false,
                'remote_route' => 'app.admin.critical_achievement.autocompleteByCourse',
                'class' => CriticalAchievement::class,
                'text_property' => 'label',
                'language' => 'fr',
                'minimum_input_length' => 0,
                'required' => true,
                'remote_params' => [
                    'courseInfo' => $builder->getData()->getCourseInfo()->getId()
                ],
            ])
            ->add('rule', ChoiceType::class, [
                'choices' => CriticalAchievementRules::RULES,
                'required' => true
            ])
            ->add('score', IntegerType::class, [
                'label' => 'Score :',
                'required' => true,
                'data' => 0
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseCriticalAchievement::class
        ]);
    }
}