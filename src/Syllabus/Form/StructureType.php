<?php

namespace App\Syllabus\Form;

use App\Syllabus\Form\Type\CustomCheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $context = $options['context'];
        $builder
            ->add('code', null, [
                'label' => 'app.form.structure.label.code',
            ])
            ->add('label', null, [
            ])
            ->add('synchronized', CustomCheckboxType::class, [
                'label' => 'app.form.structure.label.synchronized'
            ])
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
                ])
               ->remove('label')
               ->remove('code');
            }
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Syllabus\Entity\Structure',
            'context' => 'edit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'appbundle_structure';
    }


}
