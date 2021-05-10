<?php


namespace App\Syllabus\Form;


use App\Syllabus\Entity\Course;
use App\Syllabus\Form\Subscriber\CriticalAchievementTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class CriticalAchievementType
 * @package App\Syllabus\Form
 */
class CriticalAchievementType extends AbstractType
{
    /**
     * @var CriticalAchievementTypeSubscriber
     */
    private $criticalAchievementTypeSubscriber;

    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

    public function __construct(CriticalAchievementTypeSubscriber $criticalAchievementTypeSubscriber, RequestStack $requestStack)
    {
        $this->criticalAchievementTypeSubscriber = $criticalAchievementTypeSubscriber;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                'language' => $this->request->getLocale(),
                'minimum_input_length' => 4,
                'required' => false
            ])
            ->addEventSubscriber($this->criticalAchievementTypeSubscriber);
    }
}