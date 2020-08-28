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
     * @param array $exceptions
     * @return array
     */
    public function findLikeQuery(string $query, string $field, array $exceptions = []): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['code', 'title'])) {
            $qb->andWhere('c.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }

        foreach ($exceptions as $field => $exception) {
            $qb->andWhere($qb->expr()->notIn('c.'.$field, ':'. $field))
                ->setParameter($field, $exception)
            ;
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $filters
     * @return array
     */
    public function findByFilters($filters=[]): array
    {
        return $this->findQueryBuilderForApi(['filters' => $filters])->getQuery()->getResult();
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
                case 'title':
                    $value = "%{$value}%";
                    $qb->andWhere($qb->expr()->like('c.' . $filter, ':'.$valueName));
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('c.' . $filter, ':'.$valueName));
            }
            $qb->setParameter($valueName, $value);
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

    public function getParentCoursesQbByCourse(Course $course)
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->innerJoin('c.children', 'ch')
            ->andWhere($qb->expr()->eq('ch', ':course'))
            ->setParameter('course', $course)
            ;
    }

    public function getChildrenCoursesQbByCourse(Course $course)
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->join('c.parents', 'p')
            ->andWhere($qb->expr()->eq('p', ':course'))
            ->setParameter('course', $course)
            ;
    }

}