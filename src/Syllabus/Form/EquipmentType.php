<?php

namespace App\Syllabus\Form;

use App\Syllabus\Form\Subscriber\EquipmentTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', null, [
                'label' => 'app.form.equipment.label.label',
            ])
            ->add('labelVisibility', CheckboxType::class, [
                'label' => 'app.form.equipment.label.label_visibility',
                'required' => false,
                'label_attr' => [
                    'class' => 'custom-control-label'
                ],
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ])
            ->addEventSubscriber(new EquipmentTypeSubscriber())
            ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Syllabus\Entity\Equipment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'appbundle_equipment';
    }


}
