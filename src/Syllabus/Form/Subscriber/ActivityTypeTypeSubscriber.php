<?php


namespace App\Syllabus\Form\Subscriber;


use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Manager\ActivityTypeManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ActivityTypeTypeSubscriber implements EventSubscriberInterface
{
    private $activityTypeManager;

    public function __construct(ActivityTypeManager $activityTypeManager)
    {
        $this->activityTypeManager = $activityTypeManager;
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

        /** @var ActivityType $activityType */
        $activityType = $event->getData();

        //Edit mode
        if ($activityType and $activityType->getId()) {

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