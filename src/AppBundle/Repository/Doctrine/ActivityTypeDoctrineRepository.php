<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\ActivityType;
use AppBundle\Repository\ActivityTypeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class ActivityTypeDoctrineRepository extends AbstractDoctrineRepository implements ActivityTypeRepositoryInterface
{
    /**
     * TypeActivityDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @return ActivityType|null
     * @throws \Exception
     */
    public function find(string $id): ?ActivityType
    {
        $activityType = null;
        try {
            $activityType = $this->entityManager->getRepository(ActivityType::class)->find($id);
        } catch(\Exception $e) {
            throw $e;
        }
        return $activityType;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findAll(): \ArrayObject
    {
        try {
            $activityType = new \ArrayObject();
            $qb = $this->entityManager->getRepository(ActivityType::class)->createQueryBuilder('a');
            $qb->where($qb->expr()->eq('a.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->orderBy('a.position', 'ASC')
                ->addOrderBy('a.label', 'ASC');
            foreach($this->entityManager->getRepository(ActivityType::class)
                        ->findBy([], ['label' => 'ASC']) as $activityType) {
                $activityType->append($activityType);
            }
        } catch(\Exception $e) {
            throw $e;
        }
        return $activityType;
    }

    /**
     * @param ActivityType $activityType
     * @throws \Exception
     */
    public function create(ActivityType $activityType): void
    {
        try {
            $this->entityManager->persist($activityType);
            $this->entityManager->flush();
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param ActivityType $activityType
     * @throws \Exception
     */
    public function update(ActivityType $activityType): void
    {
        try {
            $this->entityManager->persist($activityType);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param ActivityType $activityType
     * @throws \Exception
     */
    public function delete(ActivityType $activityType): void
    {
        try {
            $this->entityManager->remove($activityType);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(ActivityType::class)
            ->createQueryBuilder('a')
            ->addOrderBy('a.label', 'ASC');
    }

    public function findLikeQuery(string $query, string $type): array
    {
        return $this->entityManager->getRepository(ActivityType::class)->createQueryBuilder('a')
            ->andWhere('a.label LIKE :query ')
            ->andWhere('a.mode = :mode ')
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('mode', $type)
            ->getQuery()
            ->getResult();
    }
}