<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $context = $options['context'];
        $disabled = $context == 'edit' ? true : false;
        $builder
            ->add('code', null, [
                'disabled' => $disabled
            ])
            ->add('label', null, [
                'disabled' => $disabled
            ])
            ->add('campus')
            ;
            if ($context == 'edit') {
               $builder
                ->add('obsolete', CheckboxType::class, [
                    'label' => 'app.form.structure.label.obsolete',
                    'required' => false,
                    'label_attr' => [
                        'class' => 'custom-control-label'
                    ],
                    'attr' => [
                        'class' => 'custom-control-input'
                    ]
                ]);
            }
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Structure',
            'context' => 'edit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_structure';
    }


}
