<?php


namespace App\Syllabus\Form\Api;


use Symfony\Component\Form\FormBuilderInterface;

class LanguageType extends ApiAbstractType
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