<?php

namespace AppBundle\Form\CourseInfo\Presentation\Subcriber;

use AppBundle\Constant\TeachingMode;
use AppBundle\Entity\CourseInfo;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TeachingModeTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {

        return [FormEvents::POST_SET_DATA => 'postSetData'];
    }

    public function postSetData(FormEvent $event)
    {
/*
        $courseInfo = $event->getData();

        $mode = $courseInfo->getTeachingMode();*/

/*        if ($mode != TeachingMode::HYBRID) {

            foreach ($courseInfo->getTeachings() as $teaching) {
                    dump($mode, $teaching->getMode());
                if ($teaching->getMode() !== $mode) {
                    $courseInfo->getTeachings()->removeElement($teaching);
                }
            }

        }*/

    }
}
