<?php


namespace AppBundle\Form;


use AppBundle\Form\Subscriber\ActivityModeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ActivityModeType extends AbstractType
{
    private $activityModeTypeSubscriber;

    public function __construct(ActivityModeSubscriber $activityModeTypeSubscriber)
    {
        $this->activityModeTypeSubscriber = $activityModeTypeSubscriber;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->addEventSubscriber($this->activityModeTypeSubscriber)
        ;
    }
}