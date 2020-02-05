<?php


namespace AppBundle\Manager;


use AppBundle\Entity\ActivityType;
use Doctrine\ORM\EntityManagerInterface;

class ActivityTypeManager
{
    /**
     * @var ObjectRepository
     */
    private $em;


    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    public function create()
    {

        $activityType = new ActivityType();
        $activityType->isNew = true; // This dynamic property helps to track the new state of this entity
        $activityType->setId(Uuid::uuid4());
        $this->em->persist($activityType);

        return $activityType;
    }
}