<?php


namespace AppBundle\Form\Course;


use AppBundle\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class AddChildrenCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('children', Select2EntityType::class, [
            'label' => 'Cours enfants',
            'multiple' => true,
            'remote_route' => 'app_admin.course_autocompleteS2',
            'remote_params' => [], // static route parameters for request->query
            'class' => Course::class,
            'primary_key' => 'id',
            'text_property' => 'code',
        ]);
    }
}