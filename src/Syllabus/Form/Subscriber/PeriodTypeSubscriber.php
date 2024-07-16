<?php


namespace App\Syllabus\Form\Subscriber;


use App\Syllabus\Entity\Period;
use App\Syllabus\Manager\PeriodManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PeriodTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event): void
    {
        $form = $event->getForm();

        /** @var Period $period */
        $period = $event->getData();

        //Edit mode
        if ($period and $period->getId()) {
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