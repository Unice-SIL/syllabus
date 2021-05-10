<?php


namespace App\Syllabus\Form\Api;


use App\Syllabus\Form\Api\ApiAbstractType;
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