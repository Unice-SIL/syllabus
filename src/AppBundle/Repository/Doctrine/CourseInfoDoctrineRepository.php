<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CourseInfoDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseInfoDoctrineRepository  extends ServiceEntityRepository
{

    /**
     * CourseInfoDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseInfo::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(CourseInfo::class)
            ->createQueryBuilder('ci')
            ->innerJoin('ci.course', 'c')
            ->innerJoin('ci.year', 'y')
            ->innerJoin('ci.structure', 's')
            ->addSelect('y', 'c', 's')
            ->addOrderBy('c.code', 'ASC')
            ->addOrderBy('y.id', 'ASC')
            ->addOrderBy('ci.title', 'ASC');
    }

    /**
     * @param $code
     * @param $year
     * @return CourseInfo|null
     * @throws \Exception
     */
    public function findByCodeAndYear($code, $year): ?CourseInfo
    {
        $courseInfo = null;
        try{
            $qb = $this->_em->getRepository(CourseInfo::class)->createQueryBuilder('ci');
            if(!empty($year)){
                $qb->join('ci.course', 'c')
                    ->join('ci.year', 'y')
                    ->where($qb->expr()->eq('c.code', ':code'))
                    ->andWhere($qb->expr()->eq('y.id', ':year'))
                    ->setParameter('code', $code)
                    ->setParameter('year', $year);
                $courseInfos = $qb->getQuery()->getResult();
            }
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
            $qb = $this->getIndexQueryBuilder();
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
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['c.code', 'c.type', 'ci.title', 'y.label', 's.label'])) {
            $qb->andWhere($field.' LIKE :query ')
            ->setParameter('query', '%' . $query . '%');
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter) {
                case 'title':
                    $qb->andWhere($qb->expr()->like('ci.' . $filter, ':'.$valueName))
                        ->setParameter($valueName, '%' . $value . '%');
                    break;
                case 'courseId':
                    $qb->andWhere($qb->expr()->eq('c.id', ':'.$valueName))
                        ->setParameter($valueName, $value);
                    break;
                case 'yearId':
                    $qb->andWhere($qb->expr()->eq('y.id', ':'.$valueName))
                        ->setParameter($valueName, $value);
                    break;
                case 'structureId':
                    $qb->andWhere($qb->expr()->eq('s.id', ':'.$valueName))
                        ->setParameter($valueName, $value);
                    break;
                case 'published':
                    if (true === $value) {
                        $qb->andWhere($qb->expr()->isNotNull('ci.publicationDate'));
                    }
                    break;
            }
        }
        return $qb;

    }

}