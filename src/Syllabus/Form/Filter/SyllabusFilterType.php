<?php


namespace App\Syllabus\Form\Filter;


use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class SyllabusFilterType
 * @package App\Syllabus\Form\Filter
 */
class SyllabusFilterType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $generator;

    /**
     * CourseInfoFilterType constructor.
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
        $builder
            ->add('title', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.course_info.label.title',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', [
                        'entityName' => 'CourseInfo',
                        'findBy' => 'title',
                        'property' => 'title'
                    ])
                ]
            ])
            ->add('structure', StructureCodeFilterType::class, [
                'label' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        $filterBuilder->leftJoin($alias . '.structure', $joinAlias);
                    };

                    $qbe->addOnce($qbe->getAlias().'.structure', 'st', $closure);
                }
            ])
            ->add('year', YearFilterType::class, [
                'label' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        $filterBuilder->leftJoin($alias . '.year', $joinAlias);
                    };

                    $qbe->addOnce($qbe->getAlias().'.year', 'ye', $closure);
                }
            ])
            ->add('publicationDate', ChoiceFilterType::class, [
                'label' => 'admin.syllabus.published_syllabus',
                'mapped' => false,
                'required' => false,
                'placeholder' => 'admin.syllabus.all',
                'choices'  => [
                    'yes' => true,
                    'no' => false,
                ],
                'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                    if (is_null($values['value'])) {
                        return null;
                    }

                    $expression = $filterQuery->getExpr()->isNull($field);

                    if ($values['value'] === true)
                    {
                        $expression = $filterQuery->getExpr()->isNotNull($field);
                    }

                    return $filterQuery->createCondition($expression);
                }
            ]);

    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'course_info_filter';
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
            ]
        ));
    }
}