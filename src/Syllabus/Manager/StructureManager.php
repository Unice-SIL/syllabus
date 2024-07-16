<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\Structure;
use App\Syllabus\Helper\ErrorManager;
use App\Syllabus\Repository\Doctrine\StructureDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StructureManager
 * @package App\Syllabus\Manager
 */
class StructureManager extends AbstractManager
{

    /**
     * @var StructureDoctrineRepository
     */
    private StructureDoctrineRepository $repository;

    /**
     * StructureManager constructor.
     * @param EntityManagerInterface $em
     * @param ErrorManager $errorManager
     * @param StructureDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, ErrorManager $errorManager, StructureDoctrineRepository $repository)
    {
        parent::__construct($em, $errorManager);
        $this->repository = $repository;
    }

    /**
     * @return Structure
     */
    public function new(): Structure
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

    protected function getClass(): string
    {
        return Structure::class;
    }


}