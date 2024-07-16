<?php


namespace App\Syllabus\Form\Api;


use Symfony\Component\Form\FormBuilderInterface;

class CampusType extends ApiAbstractType
{
    protected function buildApiForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('label')
            ->add('obsolete')
        ;
    }

}