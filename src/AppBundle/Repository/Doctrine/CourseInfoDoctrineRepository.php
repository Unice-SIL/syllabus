<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseInfo;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseInfoDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseInfoDoctrineRepository  extends AbstractDoctrineRepository implements CourseInfoRepositoryInterface
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

    /**
     * Find course info by id and year
     * @param $id
     * @param $year
     * @return CourseInfo|null
     * @throws \Exception
     */
    public function findByIdAndYear($id, $year): ?CourseInfo
    {
        $courseInfo = null;
        try{
            $courseInfo = $this->entityManager->getRepository(CourseInfo::class)->findOneBy([
                'id' => $id,
                'year' => $year,
            ]);
        }catch (\Exception $e){
            throw $e;
        }
        return $courseInfo;
    }

    /**
     * Update course info
     * @param CourseInfo $courseInfo
     * @throws \Exception
     */
    public function update(CourseInfo $courseInfo): void
    {
        try{
            $this->entityManager->persist($courseInfo);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}