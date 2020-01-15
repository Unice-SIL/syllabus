<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Structure;
use AppBundle\Repository\StructureRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class StructureDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class StructureDoctrineRepository  extends AbstractDoctrineRepository implements StructureRepositoryInterface
{

    /**
     * StructureDoctrineRepository constructor.
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
     * @return Structure|null
     * @throws \Exception
     */
    public function find(string $id): ?Structure
    {
        $structure = null;
        try{
            $structure = $this->entityManager->getRepository(Structure::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $structure;
    }

    /**
     * @param string $etbId
     * @return Structure|null
     * @throws \Exception
     */
    public function findByEtbId(string $etbId): ?Structure
    {
        $structure = null;
        try{
            $structure = $this->entityManager->getRepository(Structure::class)->findOneByEtbId($etbId);
        }catch (\Exception $e){
            throw $e;
        }
        return $structure;
    }

    /**
     * @param Structure $structure
     * @throws \Exception
     */
    public function create(Structure $structure): void
    {
        try{
            $this->entityManager->persist($structure);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Structure $structure
     * @throws \Exception
     */
    public function update(Structure $structure): void
    {
        try{
            $this->entityManager->persist($structure);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}