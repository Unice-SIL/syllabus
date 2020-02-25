<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\Period;
use AppBundle\Repository\PeriodRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class PeriodDoctrineRepository extends AbstractDoctrineRepository implements PeriodRepositoryInterface
{

    /**
     * PeriodDoctrineRepository constructor.
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
     * @return Period|null
     * @throws \Exception
     */
    public function find(string $id): ?Period
    {
        $period = null;
        try{
            $period = $this->entityManager->getRepository(period::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $period;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findAll(): \ArrayObject
    {
        $periods = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(Period::class)->createQueryBuilder('p');
            $qb->where($qb->expr()->eq('p.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->addOrderBy('p.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $period){
                $period->append($period);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $periods;
    }

    /**
     * @param Period $period
     * @throws \Exception
     */
    public function create(Period $period): void
    {
        try{
            $this->entityManager->persist($period);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Period $period
     * @throws \Exception
     */
    public function update(Period $period): void
    {
        try{
            $this->entityManager->persist($period);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Delete period
     * @param Period $period
     */
    public function delete(Period $period): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Period::class)
            ->createQueryBuilder('p')
            ->addOrderBy('p.label', 'ASC')
            ;
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(Period::class)->createQueryBuilder('p')
            ->andWhere('p.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            $qb->andWhere($qb->expr()->eq($qb->getRootAlias() . '.' . $filter, ':' . $valueName))
                ->setParameter($valueName, $value)
            ;
        }

        return $qb;
    }
}