<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CourseDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseDoctrineRepository  extends ServiceEntityRepository
{
    /**
     * CourseDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Course::class)
            ->createQueryBuilder('c')
            ->addOrderBy('c.code', 'ASC');
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['code', 'title'])) {
            $qb->andWhere('c.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config)
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter) {
                case 'code':
                case 'type':
                    $qb->andWhere($qb->expr()->like('c.' . $filter, ':'.$valueName))
                        ->setParameter($valueName, '%' . $value . '%');
                    break;
            }
        }
        return $qb;
    }

    public function findCourseWithCourseInfoAndYear(string $id)
    {

        return $this->getDefaultQueryBuilder()
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            ->leftJoin('ci.structure', 's')
            ->addSelect('s')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function getDefaultQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.courseInfos', 'ci')
            ->leftJoin('ci.year', 'y')
            ->addSelect('ci', 'y')
            ->orderBy('y.id', 'ASC')
            ;
    }

}