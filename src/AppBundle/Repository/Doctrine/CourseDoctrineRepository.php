<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Course;
use AppBundle\Repository\CourseRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CourseDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseDoctrineRepository  extends AbstractDoctrineRepository implements CourseRepositoryInterface
{

    /**
     * CourseDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @return Course|null
     * @throws \Exception
     */
    public function find(string $id): ?Course
    {
        $course = null;
        try{
            $course = $this->entityManager->getRepository(Course::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $course;
    }

    /**
     * @param $code
     * @return Course|null
     * @throws \Exception
     */
    public function findByCode($code): ?Course
    {
        $course = null;
        try{
            $course = $this->entityManager->getRepository(Course::class)->findOneByCode($code);
        }catch (\Exception $e){
            throw $e;
        }
        return $course;
    }

    /**
     * @param Course $course
     * @throws \Exception
     */
    public function create(Course $course): void
    {
        try{
            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Course $course
     * @throws \Exception
     */
    public function update(Course $course): void
    {
        try{
            $this->entityManager->persist($course);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['code', 'title'])) {
            $qb->andWhere('c.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult();
    }

    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Course::class)
            ->createQueryBuilder('c')
            ->addOrderBy('c.code', 'ASC')
            ;
    }

    public function findQueryBuilderForApi(array $config)
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter) {
                case 'code':
                case 'type':
                    $qb->andWhere($qb->expr()->like($qb->getRootAlias() . '.' . $filter, ':'.$valueName))
                        ->setParameter($valueName, '%' . $value . '%')
                    ;
                    break;
            }
        }

        return $qb;
    }

}