<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseTeacherDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseTeacherDoctrineRepository extends AbstractDoctrineRepository implements CourseTeacherRepositoryInterface
{

    /**
     * UserDoctrineRepository constructor.
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
     * @return CourseTeacher|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseTeacher
    {
        $courseTeacher = null;
        try{
            $courseTeacher = $this->entityManager->getRepository(CourseTeacher::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $courseTeacher;
    }


    /**
     * @param CourseTeacher $courseTeacher
     * @throws \Exception
     */
    public function create(CourseTeacher $courseTeacher): void
    {
        try{
            $this->entityManager->persist($courseTeacher);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Delete a course teacher
     * @param CourseTeacher $courseTeacher
     * @throws \Exception
     */
    public function delete(CourseTeacher $courseTeacher): void
    {
        try {
            $this->entityManager->remove($courseTeacher);
        }catch (\Exception $e){
            throw $e;
        }
    }

}