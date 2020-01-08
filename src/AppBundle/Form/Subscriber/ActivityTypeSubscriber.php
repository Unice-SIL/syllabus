<?php


namespace AppBundle\Form\Subscriber;

use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ActivityTypeSubscriber implements EventSubscriberInterface
{

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

        if ($activity->getType() === ActivityType::ACTIVITY) {
            $modeChoices = ActivityMode::$activityModes;
            $grpChoices = ActivityGroup::$activityGroups;
        }

        $form->add('mode', ChoiceType::class, [
            'label' => 'app.form.activity.label.mode',
            'choices' => array_combine($modeChoices, $modeChoices)
        ])
            ->add('grp', ChoiceType::class, [
                'label' => 'app.form.activity.label.grp',
                'choices' => array_combine($grpChoices, $grpChoices)
            ])
        ;

        //Edit mode
        if ($activity and null !== $activity->getId()) {

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