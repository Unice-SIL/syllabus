<?php

namespace App\Syllabus\Form\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\SharedableFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class CriticalAchievementFilterType
 * @package App\Syllabus\Form\Filter
 */
class CriticalAchievementFilterType extends AbstractType
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $generator;

    /**
     * CriticalAchievementFilterType constructor.
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
            ->add('label', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
                'label' => 'app.form.activity.label.label',
                'attr' => [
                    'class' => 'autocomplete-input',
                    'data-autocomplete-path' => $this->generator->generate('app.common.autocomplete.generic', ['entityName' => 'CriticalAchievement']),
                    'data-autocomplete-min-chars' => 4
                ]
            ])
        ;
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'critical_achievement_filter';
    }
}