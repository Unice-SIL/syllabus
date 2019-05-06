<?php

namespace AppBundle\Repository\Doctrine;

use Doctrine\ORM\EntityManager;

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

    /**
     * Begin a transaction
     * @throws \Exception
     */
    public function beginTransaction(): void
    {
        try{
            $this->entityManager->beginTransaction();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Commit change in database
     * @throws \Exception
     */
    public function commit(): void
    {
        try{
            $this->entityManager->commit();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Rollback change
     * @throws \Exception
     */
    public function rollback(): void
    {
        try{
            $this->entityManager->rollback();
        }catch (\Exception $e){
            throw $e;
        }
    }
}