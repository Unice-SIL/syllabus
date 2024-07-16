<?php

namespace App\Syllabus\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class StructureCodeFilterType
 * @package App\Syllabus\Form\Filter
 */
class StructureCodeFilterType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $generator;

    /**
     * StructureFilterType constructor.
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
            'label' => 'admin.syllabus.structure',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', [
                    'entityName' => 'Structure',
                    'findBy' => 'label',
                    'property' => 'label'
                ])
            ]
        ]);
    }

    /**
     * @return null|string
     */
    public function getParent(): ?string
    {
        return SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'structure_filter';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'method' => 'get',
            'attr' => [
                'class' => 'filter-form'
            ],
            'context' => 'structure'
        ));
    }
}