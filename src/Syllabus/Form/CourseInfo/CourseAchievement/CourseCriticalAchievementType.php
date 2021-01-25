<?php


namespace App\Syllabus\Form\CourseInfo\CourseAchievement;


use App\Syllabus\Constant\CriticalAchievementRules;
use App\Syllabus\Entity\CourseCriticalAchievement;
use App\Syllabus\Entity\CriticalAchievement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class CourseCriticalAchievementType
 * @package App\Syllabus\Form\CourseInfo\CourseAchievement
 */
class CourseCriticalAchievementType extends AbstractType
{
    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * CourseCriticalAchievementType constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('criticalAchievement', Select2EntityType::class, [
                'label' => 'admin.sidebar.critical_achievements',
                'multiple' => false,
                'remote_route' => 'app.admin.critical_achievement.autocompleteByCourse',
                'class' => CriticalAchievement::class,
                'text_property' => 'label',
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 2,
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