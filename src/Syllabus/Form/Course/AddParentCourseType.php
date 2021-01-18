<?php


namespace App\Syllabus\Form\Course;


use App\Syllabus\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class AddParentCourseType
 * @package AppBundle\Form\Course
 */
class AddParentCourseType extends AbstractType
{
    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * AddParentCourseType constructor.
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
        /** @var Course $course */
        $course = $builder->getData();

        $builder->add('parents', Select2EntityType::class, [
            'label' => 'admin.course.couse_parents',
            'multiple' => true,
            'remote_route' => 'app_admin.course_autocompleteS2',
            'remote_params' => ['course_id' => $course->getId()], // static route parameters for request->query
            'class' => Course::class,
            'primary_key' => 'id',
            'text_property' => 'code',
            'language' => $this->request->getLocale(),
            'minimum_input_length' => 4,
        ]);
    }
}