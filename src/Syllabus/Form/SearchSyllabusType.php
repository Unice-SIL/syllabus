<?php


namespace App\Syllabus\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

/**
 *
 */
class SearchSyllabusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('search', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'app.homepage.search_syllabus_placeholder',
                'minlength' => 4
            ],
            'constraints' => [
                new Length(null, 4)
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label' => false
        ));
    }
}