<?php


namespace AppBundle\Form\Api;


use Symfony\Component\Form\FormBuilderInterface;

class CampusType extends ApiAbstractType
{
    protected function buildApiForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('label')
            ->add('obsolete')
        ;
    }

}