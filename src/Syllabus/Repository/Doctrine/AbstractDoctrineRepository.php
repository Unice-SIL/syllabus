<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\Activity;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class AbstractDoctrineRepository
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    protected $repository;

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
     * @throws MappingException
     */
    public function clear(){
        $this->entityManager->clear();
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(){
        return $this->entityManager;
    }
}