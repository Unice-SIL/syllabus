<?php


namespace AppBundle\Manager;


use AppBundle\Constant\ActivityGroup;
use AppBundle\Constant\ActivityMode;
use AppBundle\Constant\ActivityType;
use AppBundle\Entity\Activity;
use AppBundle\Repository\ActivityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class ActivityManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var ActivityRepositoryInterface
     */
    private $repository;


    public function __construct(EntityManagerInterface $em, ActivityRepositoryInterface $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function create()
    {
        return new Activity();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $activities = $this->repository->findAll();
        return $activities;
    }

    public function findByCriteria($type)
    {
        $activities = $this->repository->findByCriteria($type);
        return $activities;
    }

    public function getModeChoicesByType($type)
    {
        switch ($type) {
            case ActivityType::ACTIVITY:
                return ActivityMode::ACTIVITY_MODES;
            case ActivityType::EVALUATION:
                return ActivityMode::EVALUATION_MODES;
            default:
                throw new \LogicException('This activity type' . $type . 'is not handled!');
        }
    }

    public function getGroupeChoicesByType($type)
    {
        switch ($type) {
            case ActivityType::ACTIVITY:
                return ActivityGroup::ACTIVITY_GROUPS;
            default:
                throw new \LogicException('This activity type' . $type . 'is not handled!');
        }
    }

}