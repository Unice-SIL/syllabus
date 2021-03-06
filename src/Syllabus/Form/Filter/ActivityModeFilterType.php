<?php

namespace App\Syllabus\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ActivityModeFilterType
 * @package App\Syllabus\Form\Filter
 */
class ActivityModeFilterType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    /**
     * ActivityModeFilterType constructor.
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
        $builder
            ->add('label', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.activity.label.label',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', [
                        'entityName' => 'ActivityMode',
                        'findBy' => 'label',
                        'property' => 'label'
                    ])
                ]
            ])
        ;
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
        return 'activity_mode_filter';
    }
}