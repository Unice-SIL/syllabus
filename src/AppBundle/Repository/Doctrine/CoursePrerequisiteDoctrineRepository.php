<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Repository\CoursePrerequisiteRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseAchievementDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CoursePrerequisiteDoctrineRepository extends AbstractDoctrineRepository implements CoursePrerequisiteRepositoryInterface
{

    /**
     * CoursePrerequisiteDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @return CoursePrerequisite|null
     * @throws \Exception
     */
    public function find(string $id): ?CoursePrerequisite
    {
        $coursePrerequisite = null;
        try{
            $coursePrerequisite = $this->entityManager->getRepository(CoursePrerequisite::class)->find($id);
            return $coursePrerequisite;
        }catch (\Exception $e){
            throw $e;
        }
    }


    /**
     * @param CoursePrerequisite $coursePrerequisite
     * @throws \Exception
     */
    public function create(CoursePrerequisite $coursePrerequisite): void
    {
        try{
            $this->entityManager->persist($coursePrerequisite);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param CoursePrerequisite $coursePrerequisite
     * @throws \Exception
     */
    public function delete(CoursePrerequisite $coursePrerequisite): void
    {
        try {
            $this->entityManager->remove($coursePrerequisite);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}