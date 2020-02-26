<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Activity;
use AppBundle\Repository\ActivityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class ActivityDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class ActivityDoctrineRepository extends AbstractDoctrineRepository implements ActivityRepositoryInterface
{
    /**
     * ActivityDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Activity::class);
    }

    /**
     * @param $id
     * @return Activity|null
     */
    public function find($id): ?Activity
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Activity $activity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Activity $activity): void
    {
        $this->entityManager->persist($activity);
        $this->entityManager->flush();
    }

    /**
     * @param Activity $activity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Activity $activity): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param Activity $activity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Activity $activity): void
    {
        $this->entityManager->remove($activity);
        $this->entityManager->flush();
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(Activity::class)->createQueryBuilder('a')
            ->andWhere('a.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }

}