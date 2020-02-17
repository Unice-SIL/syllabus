<?php


namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomCheckboxType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Custom checkbox',
            'required' => false,
            'label_attr' => [
                'class' => 'custom-control-label'
            ],
            'attr' => [
                'class' => 'custom-control-input'
            ]
        ]);
    }

    public function getParent()
    {
        return CheckboxType::class;
    }


}