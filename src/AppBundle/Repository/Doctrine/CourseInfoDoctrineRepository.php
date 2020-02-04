<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseInfo;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CourseInfoDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseInfoDoctrineRepository  extends AbstractDoctrineRepository implements CourseInfoRepositoryInterface
{

    /**
     * UserDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
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

    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['c.etbId', 'c.type', 'ci.title', 'y.label', 's.label'])) {
            $qb->andWhere($field.' LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult()
        ;
    }

    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(CourseInfo::class)
            ->createQueryBuilder('ci')
            ->innerJoin('ci.course', 'c')
            ->innerJoin('ci.year', 'y')
            ->innerJoin('ci.structure', 's')
            ->addSelect('y', 'c', 's')
            ->addOrderBy('c.etbId', 'ASC')
            ->addOrderBy('y.id', 'ASC')
            ->addOrderBy('ci.title', 'ASC')
        ;
    }

    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter) {
                case 'id':
                    $qb->andWhere($qb->expr()->eq($qb->getRootAlias() . '.' . $filter, ':'.valueName))
                        ->setParameter($valueName, $value)
                    ;
                    break;
                case 'title':
                    $qb->andWhere($qb->expr()->like($qb->getRootAlias() . '.' . $filter, ':'.$valueName))
                        ->setParameter($valueName, '%' . $value . '%')
                    ;
                    break;
                case 'etbId':
                    $qb->andWhere($qb->expr()->eq('c.etbId', ':'.$valueName))
                        ->setParameter($valueName, $value)
                    ;
                    break;
                case 'yearId':
                    $qb->andWhere($qb->expr()->eq('y.id', ':'.$valueName))
                        ->setParameter($valueName, $value)
                    ;
                    break;
                case 'structureId':
                    $qb->andWhere($qb->expr()->eq('s.id', ':'.$valueName))
                        ->setParameter($valueName, $value)
                    ;
                    break;
                case 'published':
                    if (true === $value) {
                        $qb->andWhere($qb->expr()->isNotNull($qb->getRootAlias() . '.publicationDate'))
                        ;
                    }
                    break;
            }
        }

        return $qb;
    }

}