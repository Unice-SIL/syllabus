<?php


namespace App\Syllabus\Form\Api;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('import')
            ->add('edit')
            ->add('current')
        ;
        if($options['context'] === 'POST')
        {
            $builder
                ->add('id')
            ;
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'context' => null
        ]);
    }


}