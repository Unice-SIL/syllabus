<?php


namespace AppBundle\Form\Course;


use AppBundle\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class AddParentCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Course $course */
        $course = $builder->getData();

        $builder->add('parents', Select2EntityType::class, [
            'label' => 'Cours parents',
            'multiple' => true,
            'remote_route' => 'app_admin.course_autocompleteS2',
            'remote_params' => ['course_id' => $course->getId()], // static route parameters for request->query
            'class' => Course::class,
            'primary_key' => 'id',
            'text_property' => 'code',
        ]);
    }
}