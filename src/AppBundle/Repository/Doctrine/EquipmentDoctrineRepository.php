<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Equipment;
use AppBundle\Repository\EquipmentRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class EquipmentDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class EquipmentDoctrineRepository extends AbstractDoctrineRepository implements EquipmentRepositoryInterface
{

    /**
     * EquipmentDoctrineRepository constructor.
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
     * @return Equipment|null
     * @throws \Exception
     */
    public function find(string $id): ?Equipment
    {
        $equipment = null;
        try {
            $equipment = $this->entityManager->getRepository(Equipment::class)->find($id);
        } catch(\Exception $e) {
            throw $e;
        }
        return $equipment;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findAll(): \ArrayObject
    {
        $equipments = new \ArrayObject();
        try {
            foreach($this->entityManager->getRepository(Equipment::class)
                    ->findBy([], ['label' => 'ASC']) as $equipment) {
                $equipments->append($equipment);
            }
        } catch(\Exception $e) {
            throw $e;
        }
        return $equipments;
    }


    /**
     * @param Equipment $equipment
     * @throws \Exception
     */
    public function update(Equipment $equipment): void
    {
        try {
            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Equipment $equipment
     * @throws \Exception
     */
    public function create(Equipment $equipment): void
    {
        try {
            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Equipment $equipment
     * @throws \Exception
     */
    public function delete(Equipment $equipment): void
    {
        try {
            $this->entityManager->remove($equipment);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Equipment::class)
            ->createQueryBuilder('e')
            ->addOrderBy('e.label', 'ASC')
            ;
    }


    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere($qb->getRootAlias().'.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult();
    }

}