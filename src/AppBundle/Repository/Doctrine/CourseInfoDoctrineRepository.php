<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseInfo;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseInfoDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseInfoDoctrineRepository implements CourseInfoRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

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
     * Find  course info by id
     * @param string $id
     * @return CourseInfo|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseInfo
    {
        $courseInfo = null;
        try{
            $courseInfo = $this->entityManager->getRepository(CourseInfo::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $courseInfo;
    }
}