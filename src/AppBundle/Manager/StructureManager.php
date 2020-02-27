<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Structure;
use AppBundle\Repository\Doctrine\StructureDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StructureManager
 * @package AppBundle\Manager
 */
class StructureManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var StructureDoctrineRepository
     */
    private $repository;

    /**
     * StructureManager constructor.
     * @param EntityManagerInterface $em
     * @param StructureDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, StructureDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Structure
     */
    public function new()
    {
        return new Structure();
    }

    /**
     * @param $id
     * @return Structure|null
     */
    public function find($id): ?Structure
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $code
     * @return Structure|null
     */
    public function findByCode(string $code): ?Structure
    {
        return $this->repository->findOneBy($code);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Structure $structure
     */
    public function create(Structure $structure): void
    {
        $this->em->persist($structure);
        $this->em->flush();
    }

    /**
     * @param Structure $structure
     */
    public function update(Structure $structure): void
    {
        $this->em->flush();
    }

    /**
     * @param Structure $structure
     */
    public function delete(Structure $structure): void
    {
        $this->em->remove($structure);
        $this->em->flush();
    }
}