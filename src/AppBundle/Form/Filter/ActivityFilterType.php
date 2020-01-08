<?php

namespace AppBundle\Form\Filter;

use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use AppBundle\Manager\ActivityManager;
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
    private  $activityManager;

    public function __construct(UrlGeneratorInterface $generator, ActivityManager $activityManager)
    {
        $this->generator = $generator;
        $this->activityManager = $activityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $options['type'];


        $builder->add('label', TextFilterType::class, [
            'condition_pattern' => FilterOperands::STRING_CONTAINS,
            'label' => 'app.form.activity.label.label',
            'attr' => [
                'class' => 'autocomplete-input',
                'data-autocomplete-path' => $this->generator->generate('app_admin_activity_autocomplete', ['type' => $type])
            ]
        ]);

        $modeChoices = $this->activityManager->getModeChoicesByType($type);
        $builder->add('mode', ChoiceFilterType::class, [
            'label' => 'app.form.activity.label.mode',
            'choices' => array_combine($modeChoices, $modeChoices)
        ]);
        if ($type === ActivityType::ACTIVITY) {
            $grpChoices = $this->activityManager->getGroupeChoicesByType($type);
            $builder->add('grp', ChoiceFilterType::class, [
                'label' => 'app.form.activity.label.grp',
                'choices' => array_combine($grpChoices, $grpChoices)
            ]);
        }
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