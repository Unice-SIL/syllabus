<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseInfo;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;

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
     * @param $etbId
     * @param $year
     * @return CourseInfo|null
     * @throws \Exception
     */
    public function findByEtbIdAndYear($etbId, $year): ?CourseInfo
    {
        $courseInfo = null;
        try{
            $qb = $this->entityManager->getRepository(CourseInfo::class)->createQueryBuilder('ci');
            $qb->join('ci.course', 'c')
                ->join('ci.year', 'y')
                ->where($qb->expr()->eq('c.etbId', ':etbId'))
                ->andWhere($qb->expr()->eq('y.id', ':year'))
                ->setParameter('etbId', $etbId)
                ->setParameter('year', $year);
            $courseInfos = $qb->getQuery()->getResult();
            if(!empty($courseInfos)){
                $courseInfo = current($courseInfos);
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseInfo;
    }

    /**
     * @param $year
     * @return array
     * @throws \Exception
     */
    public function findByYear($year): array
    {
        $coursesInfo = [];
        try{
            $qb = $this->entityManager->getRepository(CourseInfo::class)->createQueryBuilder('ci');
            $qb->join('ci.year', 'y')
                ->where($qb->expr()->eq('y.id', ':year'))
                ->setParameter('year', $year);
            $coursesInfo = $qb->getQuery()->getResult();
        }catch (\Exception $e){
            throw $e;
        }
        return $coursesInfo;
    }

    /**
     * @param CourseInfo $courseInfo
     * @throws \Exception
     */
    public function create(CourseInfo $courseInfo): void
    {
        try{
            $this->entityManager->persist($courseInfo);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
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