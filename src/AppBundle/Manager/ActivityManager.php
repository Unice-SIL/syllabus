<?php


namespace AppBundle\Manager;


use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use AppBundle\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class ActivityManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;


    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    public function create(string $type)
    {
        if (!in_array($type, ActivityType::$allTypes)) {
            throw new \LogicException('This activity type' . $type . 'is not handled by the application!');
        }

        $activity = new Activity();
        $activity->isNew = true; // This dynamic property helps to track the new state of this entity
        $activity->setId(Uuid::uuid4());
        $activity->setType($type);
        $this->em->persist($activity);

        return $activity;
    }

    public function getModeChoicesByType($type)
    {
        switch ($type) {
            case ActivityType::ACTIVITY:
                return ActivityMode::$activityModes;
            case ActivityType::EVALUATION:
                return ActivityMode::$roleModes;
            default:
                throw new \LogicException('This activity type' . $type . 'is not handled!');
        }
    }

    public function getGroupeChoicesByType($type)
    {
        switch ($type) {
            case ActivityType::ACTIVITY:
                return ActivityGroup::$activityGroups;
            default:
                throw new \LogicException('This activity type' . $type . 'is not handled!');
        }
    }

}