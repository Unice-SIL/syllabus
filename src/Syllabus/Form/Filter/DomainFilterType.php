<?php

namespace App\Syllabus\Form\Filter;

use App\Syllabus\Entity\Domain;
use App\Syllabus\Manager\DomainManager;
use App\Syllabus\Repository\Doctrine\StructureDoctrineRepository;
use App\Syllabus\Repository\StructureRepositoryInterface;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DomainFilterType
 * @package AppBundle\Form\Filter
 */
class DomainFilterType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    /**
     * @var DomainManager
     */
    private $domainManager;

    /**
     * @var StructureDoctrineRepository
     */
    private $structureRepository;

    private $domain;

    public function __construct(UrlGeneratorInterface $generator, DomainManager $domainManager, StructureDoctrineRepository $structureRepository)
    {
        $this->generator = $generator;
        $this->domainManager = $domainManager;
        $this->structureRepository = $structureRepository;
        $this->domain = new Domain();
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
                        'entityName' => 'Domain',
                        'findBy' => 'label',
                        'property' => 'label'
                    ])
                ]
            ])
            ->add('structures', DomainStructureFilterType::class, [
                'label' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe) {

                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        $filterBuilder->leftJoin($alias . '.structures', $joinAlias);
                    };

                    $qbe->addOnce($qbe->getAlias().'.structures', 'at', $closure);
                }
            ])
        ;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'activity_filter';
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
            'type' => $this->structureRepository->findAll(),
            'attr' => [
                'class' => 'filter-form'
            ]
        ));
    }
}