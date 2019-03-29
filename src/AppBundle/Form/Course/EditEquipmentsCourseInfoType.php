<?php

namespace AppBundle\Form\Course;

use AppBundle\Command\Course\EditEquipmentsCourseInfoCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

/**
 * Class EditEquipmentsCourseInfoType
 * @package AppBundle\Form\Course
 */
class EditEquipmentsCourseInfoType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('educationalResources', CKEditorType::class, [
            'label' => 'Description',
            'required' => false,
        ])
        ->add('bibliographicResources', CKEditorType::class, [
            'label' => 'Description',
            'required' => false,
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditEquipmentsCourseInfoCommand::class,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName(){
        return EditEquipmentsCourseInfoType::class;
    }
}