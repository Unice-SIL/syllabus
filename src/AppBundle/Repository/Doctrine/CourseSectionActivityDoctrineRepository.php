<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseSectionActivity;
use AppBundle\Repository\CourseSectionActivityRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseSectionActivityDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseSectionActivityDoctrineRepository extends AbstractDoctrineRepository implements CourseSectionActivityRepositoryInterface
{

    /**
     * CourseSectionActivityDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find  course section activity by id
     * @param string $id
     * @return CourseSectionActivity|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseSectionActivity
    {
        $courseSectionActivity = null;
        try{
            $courseSectionActivity = $this->entityManager->getRepository(CourseSectionActivity::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $courseSectionActivity;
    }


    /**
     * Create a course section activity
     * @param CourseSectionActivity $courseSectionActivity
     * @throws \Exception
     */
    public function create(CourseSectionActivity $courseSectionActivity): void
    {
        try{
            $this->entityManager->persist($courseSectionActivity);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Delete a course section activity
     * @param CourseSectionActivity $courseSectionActivity
     * @throws \Exception
     */
    public function delete(CourseSectionActivity $courseSectionActivity): void
    {
        try {
            $this->entityManager->remove($courseSectionActivity);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}