<?php


namespace AppBundle\Form\Api;


use AppBundle\Entity\Course;
use AppBundle\Form\Api\Type\ApiCollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class LevelType extends ApiAbstractType
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