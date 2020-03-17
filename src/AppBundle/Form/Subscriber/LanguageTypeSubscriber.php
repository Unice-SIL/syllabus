<?php


namespace AppBundle\Form\Subscriber;


use AppBundle\Entity\Language;
use AppBundle\Manager\LanguageManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class LanguageTypeSubscriber implements EventSubscriberInterface
{
    private $languageManager;

    public function __construct(LanguageManager $languageManager)
    {
        $this->languageManager = $languageManager;
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

        /** @var Language $language */
        $language = $event->getData();

        //Edit mode
        if ($language and $language->getId()) {
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
                ->remove('locale')
            ;
        }
    }
}