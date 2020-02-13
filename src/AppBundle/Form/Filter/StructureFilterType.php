<?php


namespace AppBundle\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class StructureFilterType extends AbstractType
{
    private  $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['context']) {
            case 'structure':
                $dataAutocompletePath = 'app_admin_structure_autocomplete';
                $fieldLabel = 'label';
                break;
            case 'course_info':
                $dataAutocompletePath = 'app_admin_course_info_autocomplete';
                $fieldLabel = 's.label';
                break;
        }

        $builder->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => $options['context'] === 'structure' ? 'app.form.structure.label.label' : 'app.form.structure.label.structure',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate($dataAutocompletePath, ['field' => $fieldLabel])
            ]
        ]);

        if ($options['context'] === 'structure') {
            $builder->add('code', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.structure.label.code',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate($dataAutocompletePath, ['field' => 'code'])
                ]
            ]);
        }
    }

    public function getParent()
    {
        return SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    public function getBlockPrefix()
    {
        return 'structure_filter';
    }

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