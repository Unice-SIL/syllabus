<?php

namespace AppBundle\Form\Filter;

use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActivityFilterType extends AbstractType
{
    private  $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['context'] == ActivityType::ACTIVITY) {
            $modeChoices = ActivityMode::$activityModes;
            $grpChoices = ActivityGroup::$activityGroups;
        }

        $builder->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => 'app.form.activity.label.label',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate('app_admin_activity_autocomplete')
            ]
        ]);
        $builder->add('mode', ChoiceFilterType::class, [
            'label' => 'app.form.activity.label.mode',
            'choices' => array_combine($modeChoices, $modeChoices)
        ]);
        $builder->add('grp', ChoiceFilterType::class, [
            'label' => 'app.form.activity.label.grp',
            'choices' => array_combine($grpChoices, $grpChoices)
        ]);
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
            'context' => ActivityType::ACTIVITY,
            'attr' => [
                'class' => 'filter-form'
            ]
        ));
    }
}