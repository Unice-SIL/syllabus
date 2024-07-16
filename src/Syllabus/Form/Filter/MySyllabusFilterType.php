<?php


namespace App\Syllabus\Form\Filter;


use App\Syllabus\Entity\Year;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SyllabusFilterType
 * @package App\Syllabus\Form\Filter
 */
class MySyllabusFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextFilterType::class, [
                'label' => 'app.form.course_info.label.title',
                'condition_pattern' => FilterOperands::STRING_CONTAINS
            ])
            ->add('code', TextFilterType::class, [
                'label' => 'app.form.course.label.code',
                'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                    if (!empty($values['value'])) {
                        $qb = $filterQuery->getQueryBuilder();
                        $qb->andWhere('c.code LIKE :code')
                            ->setParameter('code', '%' . $values['value'] . '%');
                    }
                },
            ])
            ->add('year', EntityFilterType::class, [
                'label' => 'app.form.year.label.label',
                'class' => Year::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('y')
                        ->orderBy('y.id', 'DESC');
                },
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