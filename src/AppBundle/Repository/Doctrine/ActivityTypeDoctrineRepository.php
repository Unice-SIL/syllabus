<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\ActivityType;
use AppBundle\Repository\ActivityTypeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ActivityTypeDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class ActivityTypeDoctrineRepository extends AbstractDoctrineRepository implements ActivityTypeRepositoryInterface
{
    /**
     * TypeActivityDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, ActivityType::class);
    }

    /**
     * @param string $id
     * @return ActivityType|null
     */
    public function find(string $id): ?ActivityType
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $this->repository->findAll();
    }

    /**
     * @param ActivityType $activityType
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(ActivityType $activityType): void
    {
        $this->entityManager->persist($activityType);
        $this->entityManager->flush();
    }

    /**
     * @param ActivityType $activityType
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(ActivityType $activityType): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param ActivityType $activityType
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(ActivityType $activityType): void
    {
        $this->entityManager->remove($activityType);
        $this->entityManager->flush();
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        return $this->entityManager->getRepository(ActivityType::class)->createQueryBuilder('a')
            ->andWhere('a.'.$field.' LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->addOrderBy('a.label', 'ASC')
            ->getQuery()
            ->getResult();
    }
}