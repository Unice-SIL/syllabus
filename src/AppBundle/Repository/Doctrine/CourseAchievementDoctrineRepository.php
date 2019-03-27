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
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find  course teacher by id
     * @param string $id
     * @return CourseAchievement|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseAchievement
    {
        $courseAchievement = null;
        try{
            $courseAchievement = $this->entityManager->getRepository(CourseAchievement::class)->find($id);
            return $courseAchievement;
        }catch (\Exception $e){
            throw $e;
        }
    }


    /**
     * @param CourseAchievement $courseAchievement
     * @throws \Exception
     */
    public function create(CourseAchievement $courseAchievement): void
    {
        try{
            $this->entityManager->persist($courseAchievement);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
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