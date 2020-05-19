<?php


namespace AppBundle\Form\Subscriber;


use AppBundle\Entity\Level;
use AppBundle\Form\Type\CustomCheckboxType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class LevelTypeSubscriber implements EventSubscriberInterface
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

        /** @var Level $level */
        $level = $event->getData();

        //Edit mode
        if ($level and $level->getId()) {
            $form->add('obsolete', CustomCheckboxType::class, [
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