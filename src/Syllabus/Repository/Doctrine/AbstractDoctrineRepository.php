<?php

namespace App\Syllabus\Repository\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractDoctrineRepository
 * @package App\Syllabus\Repository\Doctrine
 */
class AbstractDoctrineRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var EntityRepository
     */
    protected EntityRepository $repository;

    /**
     * AbstractDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param string $entityClassName
     */
    public function __construct(EntityManagerInterface $entityManager, string $entityClassName)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($entityClassName);
    }

    /**
     *
     */
    public function beginTransaction(): void
    {
        $this->entityManager->beginTransaction();
    }

    /**
     *
     */
    public function commit(): void
    {
        $this->entityManager->commit();
    }

    /**
     *
     */
    public function rollback(): void
    {
        $this->entityManager->rollback();
    }

    /**
     * @param $entity
     */
    public function detach($entity): void
    {
        $this->entityManager->detach($entity);
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $this->entityManager->clear();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}