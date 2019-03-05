<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Repository\CourseSectionRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseSectionDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseSectionDoctrineRepository extends AbstractDoctrineRepository implements CourseSectionRepositoryInterface
{

    /**
     * CourseSectionDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find  course section by id
     * @param string $id
     * @return CourseSection|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseSection
    {
        $courseSection = null;
        try{
            $courseSection = $this->entityManager->getRepository(CourseSection::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $courseSection;
    }


    /**
     * Create a course section
     * @param CourseSection $courseSection
     * @throws \Exception
     */
    public function create(CourseSection $courseSection): void
    {
        try{
            $this->entityManager->persist($courseSection);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Delete a course section
     * @param CourseSection $courseSection
     * @throws \Exception
     */
    public function delete(CourseSection $courseSection): void
    {
        try {
            $this->entityManager->remove($courseSection);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}