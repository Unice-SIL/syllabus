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
 * Class CourseFilterType
 * @package AppBundle\Form\Filter
 */
class CourseFilterType extends AbstractType
{
    /**
     * @var
     */
    private $generator;

    /**
     * CourseFilterType constructor.
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
            ->add('code', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.course.label.code',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', [
                        'entityName' => 'Course',
                        'findBy' => 'code',
                        'property' => 'code'
                    ]),
                    'data-autocomplete-min-chars' => 4
                ]
            ])
            ->add('title', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.course.label.title',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', [
                        'entityName' => 'Course',
                        'findBy' => 'title',
                        'property' => 'title'
                    ]),
                    'data-autocomplete-min-chars' => 4
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'method' => 'get',
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
        return 'course_filter';
    }
}