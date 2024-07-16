<?php


namespace App\Syllabus\Form;


use App\Syllabus\Form\Subscriber\ActivityModeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityModeType extends AbstractType
{
    private ActivityModeSubscriber $activityModeTypeSubscriber;

    public function __construct(ActivityModeSubscriber $activityModeTypeSubscriber)
    {
        $this->activityModeTypeSubscriber = $activityModeTypeSubscriber;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->addEventSubscriber($this->activityModeTypeSubscriber)
        ;
    }
}