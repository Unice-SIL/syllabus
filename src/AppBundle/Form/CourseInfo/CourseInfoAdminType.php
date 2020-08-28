<?php


namespace AppBundle\Form\CourseInfo;


use AppBundle\Entity\Course;
use AppBundle\Entity\Structure;
use AppBundle\Entity\Year;
use AppBundle\Form\Type\CourseWithHierarchyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class CourseInfoAdminType extends AbstractType
{

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
                'page_limit' => 10,
                'placeholder' => 'Choisissez une structure',
                'required' => true
            ])
            ->add('year', Select2EntityType::class, [
                'multiple' => false,
                'remote_route' => 'app.common.autocomplete.generic_s2',
                'class' => Year::class,
                'text_property' => 'label',
                'label' => 'app.form.year.label.label',
                'page_limit' => 10,
                'placeholder' => 'Choisissez une année',
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