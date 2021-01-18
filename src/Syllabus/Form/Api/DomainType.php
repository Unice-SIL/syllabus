<?php


namespace App\Syllabus\Form\Api;


use App\Syllabus\Entity\Course;
use App\Syllabus\Form\Api\Type\ApiCollectionType;
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