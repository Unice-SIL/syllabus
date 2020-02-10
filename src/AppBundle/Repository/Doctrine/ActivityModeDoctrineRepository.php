<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\ActivityMode;
use AppBundle\Repository\ActivityModeRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class ActivityModeDoctrineRepository extends AbstractDoctrineRepository implements ActivityModeRepositoryInterface
{
    /**
     * ActivityModeDoctrineRepository constructor.
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
     * @return ActivityMode|null
     * @throws \Exception
     */
    public function find(string $id): ?ActivityMode
    {
        $activityType = null;
        try {
            $activityType = $this->entityManager->getRepository(ActivityMode::class)->find($id);
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
            $activityMode = new \ArrayObject();
            $qb = $this->entityManager->getRepository(ActivityMode::class)->createQueryBuilder('a');
            $qb->where($qb->expr()->eq('a.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->orderBy('a.position', 'ASC')
                ->addOrderBy('a.label', 'ASC');
            foreach($this->entityManager->getRepository(ActivityMode::class)
                        ->findBy([], ['label' => 'ASC']) as $activityMode) {
                $activityMode->append($activityMode);
            }
        } catch(\Exception $e) {
            throw $e;
        }
        return $activityMode;
    }

    /**
     * @param ActivityMode $activityMode
     * @throws \Exception
     */
    public function create(ActivityMode $activityMode): void
    {
        try {
            $this->entityManager->persist($activityMode);
            $this->entityManager->flush();
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param ActivityMode $activityMode
     * @throws \Exception
     */
    public function update(ActivityMode $activityMode): void
    {
        try {
            $this->entityManager->persist($activityMode);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param ActivityMode $activityMode
     * @throws \Exception
     */
    public function delete(ActivityMode $activityMode): void
    {
        try {
            $this->entityManager->remove($activityMode);
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
        return $this->entityManager->getRepository(ActivityMode::class)
            ->createQueryBuilder('a')
            ->addOrderBy('a.label', 'ASC');
    }

    /**
     * @param string $query
     * @param string $field
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