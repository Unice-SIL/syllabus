<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Course;
use AppBundle\Entity\Year;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

/**
 * Class YearDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class YearDoctrineRepository  extends ServiceEntityRepository
{
    /**
     * YearDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Year::class);
    }

    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Year::class)
            ->createQueryBuilder('y')
            ->addOrderBy('y.id', 'ASC');
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['y.label'])) {
            $qb->andWhere($field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
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
    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter) {
                case 'label':
                    $qb->andWhere($qb->expr()->like('y.' . $filter, ':'.$valueName));
                    $value = "%{$value}%";
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('y.' . $filter, ':'.$valueName));
            }
            $qb->setParameter($valueName, $value);
        }

        return $qb;
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return $this->_entityName;
    }

    /**
     * @param string $entityName
     * @return YearDoctrineRepository
     */
    public function setEntityName(string $entityName): YearDoctrineRepository
    {
        $this->_entityName = $entityName;
        return $this;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->_em;
    }

    /**
     * @param EntityManager $em
     * @return YearDoctrineRepository
     */
    public function setEm(EntityManager $em): YearDoctrineRepository
    {
        $this->_em = $em;
        return $this;
    }

    /**
     * @return Mapping\ClassMetadata
     */
    public function getClass(): Mapping\ClassMetadata
    {
        return $this->_class;
    }

    /**
     * @param Mapping\ClassMetadata $class
     * @return YearDoctrineRepository
     */
    public function setClass(Mapping\ClassMetadata $class): YearDoctrineRepository
    {
        $this->_class = $class;
        return $this;
    }

    public function getAvailableYearsByCourseBuilder(Course $course)
    {
        $qb = $this->createQueryBuilder('y');
        $qb
            ->leftJoin('y.courseInfos', 'ci')
            ->leftJoin('ci.course', 'c')
            ->andWhere($qb->expr()->isNull('ci'))
            ->orWhere(($qb->expr()->in('ci', ':courseInfos') . ' AND ' . $qb->expr()->neq('c', ':course')))
            ->setParameter('course', $course)
            ->setParameter('courseInfos', $course->getCourseInfos())
            ;

        return $qb;
    }

}