<?php


namespace AppBundle\Form\CourseInfo\CourseAchievement;


use AppBundle\Entity\CourseTutoringResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveCourseTutoringResourcesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {}

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseTutoringResource::class
        ]);
    }
}