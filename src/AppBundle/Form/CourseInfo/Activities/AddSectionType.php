<?php

namespace AppBundle\Form\CourseInfo\Activities;

use AppBundle\Entity\CourseSection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddSectionType
 * @package AppBundle\Form\CourseInfo\Activities
 */
class AddSectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description', TextType::class, [
            'label' => 'Description'
        ])
            ->add('title', TextType::class, [
                'label' => "Titre de la section"
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CourseSection::class,
            'allow_extra_fields' => true
        ]);
    }
}