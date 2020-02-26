<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseAchievement;
use AppBundle\Repository\CourseAchievementRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseAchievementDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseAchievementDoctrineRepository extends AbstractDoctrineRepository implements CourseAchievementRepositoryInterface
{

    /**
     * CourseAchievementDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, CourseAchievement::class);
    }

    /**
     * @param string $id
     * @return CourseAchievement|null
     */
    public function find(string $id): ?CourseAchievement
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
     * @param CourseAchievement $courseAchievement
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(CourseAchievement $courseAchievement): void
    {
        $this->entityManager->persist($courseAchievement);
        $this->entityManager->flush();
    }

    /**
     * @param CourseAchievement $courseAchievement
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(CourseAchievement $courseAchievement): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param CourseAchievement $courseAchievement
     * @throws \Exception
     */
    public function delete(CourseAchievement $courseAchievement): void
    {
        try {
            $this->entityManager->remove($courseAchievement);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }
}