<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\ActivityMode;
use AppBundle\Repository\ActivityModeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ActivityModeDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class ActivityModeDoctrineRepository extends AbstractDoctrineRepository implements ActivityModeRepositoryInterface
{
    /**
     * ActivityModeDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, ActivityMode::class);
    }

    /**
     * @param string $id
     * @return ActivityMode|null
     * @throws \Exception
     */
    public function find(string $id): ?ActivityMode
    {
        return $this->repository->find($id);
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
     * @param ActivityMode $activityMode
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(ActivityMode $activityMode): void
    {
        $this->entityManager->persist($activityMode);
        $this->entityManager->flush();
    }

    /**
     * @param ActivityMode $activityMode
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(ActivityMode $activityMode): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param ActivityMode $activityMode
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(ActivityMode $activityMode): void
    {
        $this->entityManager->remove($activityMode);
        $this->entityManager->flush();
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(ActivityMode::class)->createQueryBuilder('am')
            ->andWhere('am.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }
}