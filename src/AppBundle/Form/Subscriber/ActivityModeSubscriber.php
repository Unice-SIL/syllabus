<?php


namespace AppBundle\Form\Subscriber;


use AppBundle\Entity\ActivityMode;
use AppBundle\Manager\ActivityModeManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ActivityModeSubscriber implements EventSubscriberInterface
{

    private $activitymodeManager;

    public function __construct(ActivityModeManager $activityModeManager)
    {
        $this->activitymodeManager = $activityModeManager;
    }


    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();

        /** @var ActivityMode $activityMode */
        $activityMode = $event->getData();

        //Edit mode
        if ($activityMode and $activityMode->getId()) {

            $form->add('obsolete', CheckboxType::class, [
                'label' => 'admin.form.obsolete',
                'required' => false,
                'label_attr' => [
                    'class' => 'custom-control-label'
                ],
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ])
            ;
        }
    }
}