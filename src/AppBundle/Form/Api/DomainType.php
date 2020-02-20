<?php


namespace AppBundle\Form\Api;


use AppBundle\Entity\Course;
use AppBundle\Form\Api\Type\ApiCollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class DomainType extends ApiAbstractType
{
    protected function buildApiForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('label')
            ->add('obsolete')
            /*->add('structures', ApiCollectionType::class, [
                'entry_type'=> Course::class
            ])*/
        ;
    }

}