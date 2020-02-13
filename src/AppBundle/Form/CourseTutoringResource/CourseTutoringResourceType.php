<?php

namespace AppBundle\Form\CourseTutoringResource;

use AppBundle\Command\CourseTutoringResource\CourseTutoringResourceCommand;
use AppBundle\Entity\CourseTutoringResource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CourseTutoringResourceType
 * @package AppBundle\Form\CourseTutoringResource
 */
class CourseTutoringResourceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Exemple : Se remettre à niveau (lien vers votre site web de cours, un MOOC, ...)'
                ]
            ])
            ->add('position', HiddenType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseTutoringResource::class,
        ]);
    }

    public function getName(){
        return CourseTutoringResourceType::class;
    }
}