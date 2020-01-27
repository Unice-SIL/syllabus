<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Year;
use AppBundle\Repository\YearRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class YearDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class YearDoctrineRepository  extends AbstractDoctrineRepository implements YearRepositoryInterface
{

    /**
     * YearDoctrineRepository constructor.
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
     * @return Year|null
     * @throws \Exception
     */
    public function find(string $id): ?Year
    {
        try{
            $year = $this->entityManager->getRepository(Year::class)->find($id);
            return $year;
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function findToImport(): array
    {
        try{
            $years = $this->entityManager->getRepository(Year::class)->findByImport(true);
            return $years;
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Year $year
     * @throws \Exception
     */
    public function create(Year $year): void
    {
        try{
            $this->entityManager->persist($year);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Year $year
     * @throws \Exception
     */
    public function update(Year $year): void
    {
        try{
            $this->entityManager->persist($year);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['y.label'])) {
            $qb->andWhere($field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult();
    }

    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Year::class)
            ->createQueryBuilder('y')
            ->addOrderBy('y.id', 'ASC')
            ;
    }

}