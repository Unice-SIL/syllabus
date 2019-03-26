<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseEvaluationCt;
use AppBundle\Repository\CourseEvaluationCtRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseEvaluationCtDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseEvaluationCtDoctrineRepository extends AbstractDoctrineRepository implements CourseEvaluationCtRepositoryInterface
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
     * @param string $id
     * @return CourseEvaluationCt|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseEvaluationCt
    {
        $courseEvaluationCt = null;
        try{
            $courseEvaluationCt = $this->entityManager->getRepository(CourseEvaluationCt::class)->find($id);
            return $courseEvaluationCt;
        }catch (\Exception $e){
            throw $e;
        }
    }


    /**
     * @param CourseEvaluationCt $courseEvaluationCt
     * @throws \Exception
     */
    public function create(CourseEvaluationCt $courseEvaluationCt): void
    {
        try{
            $this->entityManager->persist($courseEvaluationCt);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param CourseEvaluationCt $courseEvaluationCt
     * @throws \Exception
     */
    public function delete(CourseEvaluationCt $courseEvaluationCt): void
    {
        try {
            $this->entityManager->remove($courseEvaluationCt);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}