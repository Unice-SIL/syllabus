<?php


namespace App\Syllabus\Form\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class YearTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event)
    {
        $year = $event->getData();
        $form = $event->getForm();

        if (!$year || null === $year->getId()) {
            $form->add('id', TextType::class, [
                'label' => 'admin.year.year',
                'attr' => [
                    'placeholder' => 'AAAA'
                ]
            ]);

            return;
        }

        $form
            ->add('current', CheckboxType::class, [
            'label' => 'admin.year.current_year',
            'required' => false,
            'label_attr' => [
                'class' => 'custom-control-label'
            ],
            'attr' => [
                'class' => 'custom-control-input'
                ]
            ])
            ->add('import', CheckboxType::class, [
                'label' => 'admin.year.import',
                'required' => false,
                'label_attr' => [
                    'class' => 'custom-control-label'
                ],
                'attr' => [
                    'class' => 'custom-control-input'
                ]
            ])
            ->add('edit', CheckboxType::class, [
                'label' => 'admin.year.editable',
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
