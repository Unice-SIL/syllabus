<?php

namespace AppBundle\Form;

use AppBundle\Entity\SyllabusDuplicationField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SyllabusDuplicationFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('import', CheckboxType::class, [
                'label' => false,
                'required' => false,
                'label_attr' => [
                    'class' => 'custom-control-label'
                ],
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SyllabusDuplicationField::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_syllabus_duplication_field';
    }


}
