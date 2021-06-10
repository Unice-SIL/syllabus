<?php

namespace App\Syllabus\Subscriber;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Security;

/**
 * Class DatabaseActivitySubscriber
 * @package App\Syllabus\Subscriber
 */
class DatabaseActivitySubscriber implements EventSubscriber
{
    /**
     * @var Security
     */
    private $security;

    /**
     * DatabaseActivitySubscriber constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof CourseInfo) {
            $this->logCourseInfoLastUpdater($entity);
        }
    }

    /**
     * @param CourseInfo $courseInfo
     */
    private function logCourseInfoLastUpdater(CourseInfo $courseInfo)
    {
        if ($this->security instanceof Security and $this->security->getUser() instanceof User) {
            $courseInfo->setLastUpdater($this->security->getUser());
        }
    }

}