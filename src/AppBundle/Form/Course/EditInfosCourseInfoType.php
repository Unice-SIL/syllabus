<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditInfosCourseInfoCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditInfosCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditInfosCourseInfoType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditInfosCourseInfoCommand::class,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName(){
        return EditInfosCourseInfoType::class;
    }
}