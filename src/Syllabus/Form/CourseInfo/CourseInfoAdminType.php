<?php


namespace App\Syllabus\Form\CourseInfo;


use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Entity\Year;
use App\Syllabus\Form\Type\CourseWithHierarchyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class CourseInfoAdminType
 * @package App\Syllabus\Form\CourseInfo
 */
class CourseInfoAdminType extends AbstractType
{
    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * CourseInfoAdminType constructor.
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
            ->add('title')
            ->add('structure', Select2EntityType::class, [
                'label' => 'app.form.course_info.label.structure',
                'multiple' => false,
                'remote_route' => 'app_admin_structure_autocompleteS2',
                'class' => Structure::class,
                'text_property' => 'label',
                'language' => $this->request->getLocale(),
                'page_limit' => 10,
                'placeholder' => 'app.form.course_info.placeholder.structure',
                'required' => true
            ])
            ->add('year', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'app.common.autocomplete.generic_s2',
                'class' => Year::class,
                'text_property' => 'label',
                'label' => 'app.form.year.label.label',
                'language' => $this->request->getLocale(),
                'page_limit' => 10,
                'placeholder' => 'app.form.course_info.placeholder.year',
                'remote_params' => [
                    'entityName' => 'Year',
                    'findBy' => 'label',
                    'property' => 'label',
                    'findByOther' => ['obsolete' => false]
                ],
                'required' => true
            ])
            ->add('course', CourseWithHierarchyType::class, [
                'label' => false,
                'data_class' => Course::class,
            ])
            ;
    }

}