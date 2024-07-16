<?php


namespace App\Syllabus\Manager;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Repository\Doctrine\ActivityDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class ActivityManager
 * @package App\Syllabus\Manager
 */
class ActivityManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var ActivityDoctrineRepository
     */
    private ActivityDoctrineRepository $repository;

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
    public function new(): Activity
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
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @return array
     */
    public function findAllNotObsolete(): array
    {
        return $this->repository->getIndexQueryBuilder()->andWhere('a.obsolete = 0')->getQuery()->getResult();
    }

    /**
     * @param Activity $activity
     */
    public function create(Activity $activity): void
    {
        $this->em->persist($activity);
        $this->em->flush();
    }

    /**
     * @param Activity $activity
     */
    public function update(Activity $activity): void
    {
        $this->em->flush();
    }

    /**
     * @param Activity $activity
     */
    public function delete(Activity $activity): void
    {
        $this->em->remove($activity);
        $this->em->flush();
    }
}