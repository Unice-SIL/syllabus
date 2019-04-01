<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Equipment;
use AppBundle\Repository\EquipmentRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class EquipmentDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class EquipmentDoctrineRepository extends AbstractDoctrineRepository implements EquipmentRepositoryInterface
{

    /**
     * EquipmentDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
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
        try{
            $equipment = $this->entityManager->getRepository(Equipment::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $equipment;
    }

    /**
     * @param $type
     * @param $mode
     * @param $grp
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findByCriteria($type, $mode, $grp): \ArrayObject
    {
        $equipments = new \ArrayObject();
        try{
            $qb = $this->entityManager->getRepository(Equipment::class)->createQueryBuilder('a');
            $qb->where($qb->expr()->eq('a.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->orderBy('a.ord', 'ASC');
            if(!is_null($type)){
                $qb->andWhere($qb->expr()->eq('a.type', ':type'))
                    ->setParameter('type', $type);
            }
            if(!is_null($mode)){
                $qb->andWhere($qb->expr()->eq('a.mode', ':mode'))
                    ->setParameter('mode', $mode);
            }
            if(!is_null($grp)){
                $qb->andWhere($qb->expr()->eq('a.grp', ':grp'))
                    ->setParameter('grp', $grp);
            }
            foreach ($qb->getQuery()->getResult() as $equipment){
                $equipments->append($equipment);
            }
        }catch (\Exception $e){
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
        try{
            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Equipment $equipment
     * @throws \Exception
     */
    public function create(Equipment $equipment): void
    {
        try{
            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
        }catch (\Exception $e){
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
        }catch (\Exception $e){
            throw $e;
        }
    }

}