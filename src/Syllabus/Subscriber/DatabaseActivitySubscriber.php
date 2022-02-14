<?php

namespace App\Syllabus\Subscriber;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\User;
use DateTime;
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
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof CourseInfo) {
            $this->logCourseInfoCreate($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if ($entity instanceof CourseInfo) {
            $this->logCourseInfoUpdate($entity);
        }
    }

    /**
     * @param CourseInfo $courseInfo
     */
    private function logCourseInfoCreate(CourseInfo $courseInfo)
    {
        $courseInfo->setCreationDate(new DateTime());
        $this->logCourseInfoLastUpdater($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     */
    private function logCourseInfoUpdate(CourseInfo $courseInfo)
    {
        $courseInfo->setModificationDate(new DateTime());
        $this->logCourseInfoLastUpdater($courseInfo);
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