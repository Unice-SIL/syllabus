<?php


namespace App\Syllabus\Form\CourseInfo\Permission;


use App\Syllabus\Entity\CoursePermission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveCoursePermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {}

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CoursePermission::class
        ]);
    }
}