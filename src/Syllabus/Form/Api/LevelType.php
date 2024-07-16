<?php


namespace App\Syllabus\Form\Api;


use App\Syllabus\Entity\Course;
use App\Syllabus\Form\Api\Type\ApiCollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class LevelType extends ApiAbstractType
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