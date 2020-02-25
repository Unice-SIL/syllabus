<?php


namespace AppBundle\Form\Api;


use AppBundle\Form\Api\ApiAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PeriodType extends ApiAbstractType
{
    protected function buildApiForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('label')
            ->add('obsolete')
            ->add('structures')
        ;
    }

}