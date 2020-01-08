<?php


namespace AppBundle\Form\Subscriber;

use AppBundle\Constant\ActivityType;
use AppBundle\Manager\ActivityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ActivityTypeSubscriber implements EventSubscriberInterface
{

    private $activityManager;

    public function __construct(ActivityManager $activityManager)
    {
        $this->activityManager = $activityManager;
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
        $activity = $event->getData();
        $type = $activity->getType();

        $modeChoices = $this->activityManager->getModeChoicesByType($type);
        $form->add('mode', ChoiceType::class, [
            'label' => 'app.form.activity.label.mode',
            'choices' => array_combine($modeChoices, $modeChoices)
        ]);

        if ($type === ActivityType::ACTIVITY) {
            $grpChoices = $this->activityManager->getGroupeChoicesByType($type);
            $form->add('grp', ChoiceType::class, [
                    'label' => 'app.form.activity.label.grp',
                    'choices' => array_combine($grpChoices, $grpChoices)
                ])
            ;
        }

        //Edit mode
        //$activity->isNew is a dynamic property set in AppBundle\Manager\ActivityManager::create() to track the new state of the entity
        if ($activity and !isset($activity->isNew)) {

            $form->add('obsolete', CheckboxType::class, [
                'label' => 'Obsolète',
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