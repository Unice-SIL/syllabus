<?php

namespace AppBundle\Form\Filter;

use AppBundle\Constant\ActivityType;
use AppBundle\Manager\ActivityManager;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActivityFilterType extends AbstractType
{
    private  $generator;
    private  $activityManager;

    public function __construct(UrlGeneratorInterface $generator, ActivityManager $activityManager)
    {
        $this->generator = $generator;
        $this->activityManager = $activityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => 'app.form.activity.label.label',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete', ['object' => 'Activity'])
            ]
        ])
        ->add('activityTypes', ActivityTypeFilterType::class, [
        'label' => false,
        'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                    $filterBuilder->leftJoin($alias . '.activityTypes', $joinAlias);
                };

                $qbe->addOnce($qbe->getAlias().'.activityTypes', 'at', $closure);
            }
        ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'activity_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'method' => 'get',
            'type' => ActivityType::ACTIVITY,
            'attr' => [
                'class' => 'filter-form'
            ]
        ));
    }
}