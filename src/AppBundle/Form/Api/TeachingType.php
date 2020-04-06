<?php


namespace AppBundle\Form\Api;

use Symfony\Component\Form\FormBuilderInterface;

class TeachingType extends ApiAbstractType
{
    protected function buildApiForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('type')
            ->add('hourlyVolume')
            ->add('mode')
        ;
    }

}