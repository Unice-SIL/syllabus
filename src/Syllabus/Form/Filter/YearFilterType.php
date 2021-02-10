<?php

namespace App\Syllabus\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class YearFilterType
 * @package App\Syllabus\Form\Filter
 */
class YearFilterType extends AbstractType
{
    /**
     * @var
     */
    private  $generator;

    /**
     * YearFilterType constructor.
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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => 'app.form.year.label.label',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', [
                    'entityName' => 'Year',
                    'findBy' => 'label',
                    'property' => 'label'
                ])
            ]
        ]);
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'year_filter';
    }
}