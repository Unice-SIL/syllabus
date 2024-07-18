<?php

namespace App\Syllabus\Form\CourseInfo\Presentation\Subcriber;

use App\Syllabus\Constant\TeachingMode;
use App\Syllabus\Entity\CourseInfo;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TeachingModeTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {

        return [FormEvents::POST_SET_DATA => 'postSetData'];
    }

    public function postSetData(FormEvent $event): void
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
