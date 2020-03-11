<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class NotificationDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class NotificationDoctrineRepository extends ServiceEntityRepository
{

    /**
     * NotificationDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this-> _em->getRepository(Notification::class)
            ->createQueryBuilder('n');
    }

}