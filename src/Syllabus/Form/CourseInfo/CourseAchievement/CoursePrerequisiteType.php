<?php

namespace App\Syllabus\Form\CourseInfo\CourseAchievement;

use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CoursePrerequisite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class CoursePrerequisiteType
 * @package App\Syllabus\Form\CourseInfo\CourseAchievement
 */
class CoursePrerequisiteType extends AbstractType
{
    /**
     * @var null|Request
     */
    private $request;

    /**
     * CoursePrerequisiteType constructor.
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
            ->add('description', TextareaType::class, [
                'label' => 'app.prerequisites.form.prerequisite_description',
                'required' => false,
            ])
            ->add('isCourseAssociated', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'type' => 'checkbox',
                    'data-toggle' => 'toggle',
                    'data-width' => '100',
                    'data-height' => '40',
                    'data-onstyle' => 'primary',
                    'data-offstyle' => 'secondary',
                    'data-style' => 'ios',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ]
            ])
            ->add('courses', Select2EntityType::class, [
                'label' => 'app.prerequisites.form.prerequisite_courses',
                'class' => Course::class,
                'multiple' => true,
                'remote_route' => 'app.common.autocomplete.generic_s2_courses',
                'text_property' => 'title',
                'minimum_input_length' => 4,
                'language' => $this->request->getLocale(),
                'required' => false,
                'remote_params' => [
                    'entityName' => 'Course',
                    'property' => 'title',
                    'property_optional' => 'code'
                ],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoursePrerequisite::class,
            'csrf_token_id' => 'create_edit_prerequisite'
        ]);
    }
}