<?php


namespace AppBundle\Manager;

use AppBundle\Entity\Activity;
use AppBundle\Repository\Doctrine\ActivityDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class ActivityManager
 * @package AppBundle\Manager
 */
class ActivityManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var ActivityDoctrineRepository
     */
    private $repository;

    /**
     * ActivityManager constructor.
     * @param EntityManagerInterface $em
     * @param ActivityDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, ActivityDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Activity
     */
    public function new()
    {
        return new Activity();
    }

    /**
     * @param $id
     * @return Activity|null
     */
    public function find($id): ?Activity
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @return array
     */
    public function findAllNotObsolete()
    {
        return $this->repository->getIndexQueryBuilder()->andWhere('a.obsolete = 0')->getQuery()->getResult();
    }

    /**
     * @param Activity $activity
     */
    public function create(Activity $activity)
    {
        $this->em->persist($activity);
        $this->em->flush();
    }

    /**
     * @param Activity $activity
     */
    public function update(Activity $activity)
    {
        $this->em->flush();
    }

    /**
     * @param Activity $activity
     */
    public function delete(Activity $activity)
    {
        $this->em->remove($activity);
        $this->em->flush();
    }
}