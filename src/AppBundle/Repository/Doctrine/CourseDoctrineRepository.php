<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Course;
use AppBundle\Repository\CourseRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseDoctrineRepository  extends AbstractDoctrineRepository implements CourseRepositoryInterface
{

    /**
     * CourseDoctrineRepository constructor.
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
     * @return Course|null
     * @throws \Exception
     */
    public function find(string $id): ?Course
    {
        $course = null;
        try{
            $course = $this->entityManager->getRepository(Course::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $course;
    }

    /**
     * @param $etbId
     * @return Course|null
     * @throws \Exception
     */
    public function findByEtbId($etbId): ?Course
    {
        $course = null;
        try{
            $course = $this->entityManager->getRepository(Course::class)->findOneByEtbId($etbId);
        }catch (\Exception $e){
            throw $e;
        }
        return $course;
    }

    /**
     * @param Course $course
     * @throws \Exception
     */
    public function create(Course $course): void
    {
        try{
            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Course $course
     * @throws \Exception
     */
    public function update(Course $course): void
    {
        try{
            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}