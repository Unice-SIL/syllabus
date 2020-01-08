<?php

namespace AppBundle\Form\Filter;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CourseInfoFilterType extends AbstractType
{
    private  $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course', CourseFilterType::class, [
                'label' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        $filterBuilder->leftJoin($alias . '.course', $joinAlias);
                    };

                    $qbe->addOnce($qbe->getAlias().'.course', 'c', $closure);
                }
            ])
            ->add('title', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.course_info.label.title',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app_admin_course_info_autocomplete', ['field' => 'ci.title'])
                ]
            ])
            ->add('year', YearFilterType::class, [
                'label' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        $filterBuilder->leftJoin($alias . '.year', $joinAlias);
                    };

                    $qbe->addOnce($qbe->getAlias().'.year', 'y', $closure);
                }
            ])
            ->add('structure', StructureFilterType::class, [
                'label' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        $filterBuilder->leftJoin($alias . '.structure', $joinAlias);
                    };

                    $qbe->addOnce($qbe->getAlias().'.structure', 's', $closure);
                }
            ])
        ;

    }

    public function getBlockPrefix()
    {
        return 'course_info_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
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