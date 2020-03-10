<?php

namespace AppBundle\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DomainStructureFilterType
 * @package AppBundle\Form\Filter
 */
class DomainStructureFilterType extends AbstractType
{
    /**
     * @var
     */
    private  $generator;

    /**
     * DomainStructureFilterType constructor.
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
        $param = [];
        switch ($options['context']) {
            case 'structure':
                $dataAutocompletePath = 'app.common.autocomplete.generic';
                $param = [
                    'entityName' => 'Structure',
                    'findBy' => 'label',
                    'property' => 'label'
                ];
                break;
            case 'course_info':
                $dataAutocompletePath = 'app_admin_course_info_autocomplete';
                $param = ['field' => 's.label'];
                break;
        }

        $builder->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => $options['context'] === 'structure' ? 'app.form.structure.label.label' : 'app.form.structure.label.structure',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate($dataAutocompletePath, $param)
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
        return 'structure_domain_filter';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'method' => 'get',
            'attr' => [
                'class' => 'filter-form'
            ],
            'context' => 'structure'
        ));
    }
}