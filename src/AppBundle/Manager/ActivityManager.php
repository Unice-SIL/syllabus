<?php


namespace AppBundle\Manager;


use AppBundle\Constant\ActivityType;
use AppBundle\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;

class ActivityManager
{

    public function create(string $type)
    {
        if (!in_array($type, ActivityType::$allTypes)) {
            throw new \LogicException('This activity type' . $type . 'is not handled by the application!');
        }

        $activity = new Activity();
        $activity->setType($type);

        return $activity;
    }

}