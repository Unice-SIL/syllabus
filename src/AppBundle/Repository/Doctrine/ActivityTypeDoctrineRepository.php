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
    public function findAll() : \ArrayObject
    {
        $activityTypes = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(ActivityType::class)->createQueryBuilder('at');
            $qb->where($qb->expr()->eq('at.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->addOrderBy('at.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $activityType){
                $activityTypes->append($activityType);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $activityTypes;
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

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere($qb->getRootAlias().'.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult();
    }
}