<?php


namespace AppBundle\Form\Filter;

use AppBundle\Constant\ActivityMode;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class ActivityTypeFilterType extends AbstractType
{
    private $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => 'app.form.activity_type.label.label',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate('app_admin_type_activity_autocomplete', ['field' => 'label'])
            ]
        ])
            ->add('activityModes', ActivityModeFilterType::class, [
                'label' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        $filterBuilder->leftJoin($alias . '.activityModes', $joinAlias);
                    };

                    $qbe->addOnce($qbe->getAlias() . '.activityModes', 'am', $closure);
                }
            ]);
    }

    public function getParent()
    {
        return SharedableFilterType::class; // this allow us to use the "add_shared" option
    }

    public function getBlockPrefix()
    {
        return 'activity_type_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering'), // avoid NotBlank() constraint-related message
            'method' => 'get',
            'type' => ActivityMode::ACTIVITY_MODES,
            'attr' => [
                'class' => 'filter-form'
            ]
        ));
    }
}