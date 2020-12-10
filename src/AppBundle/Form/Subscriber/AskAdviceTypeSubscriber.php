<?php


namespace AppBundle\Form\Subscriber;


use AppBundle\Entity\AskAdvice;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AskAdviceTypeSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();

        /** @var AskAdvice $askAdvice */
        $askAdvice = $event->getData();

        //Edit mode
        if ($askAdvice and $askAdvice->getId()) {
            $form->add('process', CheckboxType::class, [
                'label' => 'Traité',
                'required' => false,
                'label_attr' => [
                    'class' => 'custom-control-label'
                ],
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Commentaire",
                'required' => false
            ])
            ;
        }
    }
}