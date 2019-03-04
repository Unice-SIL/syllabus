<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Form\CourseTeacher\CourseTeacherType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * Class EditCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditPresentationCourseInfoType extends AbstractType
{
    /**
     * @var array
     */
    private $teacherSources = [];

    /**
     * EditPresentationCourseInfoType constructor.
     * @param $courseTeacherFactory
     */
    public function __construct(
        $courseTeacherFactory
    )
    {
        if(is_array($courseTeacherFactory) && array_key_exists('sources', $courseTeacherFactory)){
            foreach ($courseTeacherFactory['sources'] as $id => $source){
                if(is_array($source) && array_key_exists('name', $source)){
                    $this->teacherSources[$source['name']] = $id;
                }else{
                    $this->teacherSources[$id] = $id;
                }
            }
        }
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('period', TextType::class, [
                'label' => 'Period',
                'required' => false,
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Summary',
                'required' => false,
            ])
            ->add('teachingMode', ChoiceType::class, [
                'label' => 'Teaching mode',
                'expanded'  => true,
                'multiple' => false,
                'choices' => [
                    'Classroom' => 'class',
                    'Hybrid' => 'hybrid'
                ]
            ])
            ->add('teacherSource', ChoiceType::class, [
                'mapped' => false,
                'multiple' => false,
                'expanded' => false,
                'choices' => $this->teacherSources
            ])
            ->add('teacherSearch', Select2EntityType::class, [
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'remote_route' => 'search_course_teacher_json',
                'class' => CourseTeacher::class,
                'minimum_input_length' => 2,
                'req_params' => ['source' => 'parent.children[teacherSource]'],
            ])
            ->add('teachers', CollectionType::class, [
                'entry_type' => CourseTeacherType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditPresentationCourseInfoCommand::class,
            'allow_extra_fields' => true,
        ]);
    }
}