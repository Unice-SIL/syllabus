<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\Campus;
use AppBundle\Repository\CampusRepositoryinterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CampusDoctrineRepository extends AbstractDoctrineRepository implements CampusRepositoryInterface
{
    /**
     * CampusDoctrineRepository constructor.
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
     * @return Campus|null
     * @throws \Exception
     */
    public function find(string $id): ?Campus
    {
        $campus = null;
        try{
            $campus = $this->entityManager->getRepository(Campus::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $campus;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findAll(): \ArrayObject
    {
        $campuss = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(Campus::class)->createQueryBuilder('c');
            $qb->where($qb->expr()->eq('c.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->addOrderBy('c.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $campus){
                $campus->append($campus);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $campuss;
    }

    /**
     * @param Campus $campus
     * @throws \Exception
     */
    public function create(Campus $campus): void
    {
        try{
            $this->entityManager->persist($campus);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Campus $campus
     * @throws \Exception
     */
    public function update(Campus $campus): void
    {
        try{
            $this->entityManager->persist($campus);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Delete Campus
     * @param Campus $campus
     */
    public function delete(Campus $campus): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Campus::class)
            ->createQueryBuilder('l')
            ->addOrderBy('l.label', 'ASC')
            ;
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(Campus::class)->createQueryBuilder('c')
            ->andWhere('c.label LIKE :query ')
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