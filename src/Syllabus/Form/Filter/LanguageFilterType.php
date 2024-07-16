<?php

namespace App\Syllabus\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class LanguageFilterType
 * @package App\Syllabus\Form\Filter
 */
class LanguageFilterType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $generator;

    /**
     * LanguageFilterType constructor.
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => 'app.form.equipment.label.label',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', [
                    'entityName' => 'Language',
                    'findBy' => 'label',
                    'property' => 'label'
                ])
            ]
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'language_filter';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'method' => 'get',
            'attr' => [
                'class' => 'filter-form'
            ]
        ));
    }
}