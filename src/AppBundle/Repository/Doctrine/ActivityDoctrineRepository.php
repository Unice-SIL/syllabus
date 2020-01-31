<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Activity;
use AppBundle\Repository\ActivityRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ActivityDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class ActivityDoctrineRepository extends AbstractDoctrineRepository implements ActivityRepositoryInterface
{

    /**
     * ActivityDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @return Activity|null
     * @throws \Exception
     */
    public function find(string $id): ?Activity
    {
        $activity = null;
        try{
            $activity = $this->entityManager->getRepository(Activity::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $activity;
    }

    /**
     * @return \ArrayObject|mixed
     * @throws \Exception
     */
    public function findAll()
    {
        $activities = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(Activity::class)->createQueryBuilder('a');
            $qb->where($qb->expr()->eq('a.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->orderBy('a.position', 'ASC')
                ->addOrderBy('a.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $activity){
                $activities->append($activity);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $activities;
    }

    /**
     * @param $type
     * @param $mode
     * @param $grp
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findByCriteria($type, $mode, $grp): \ArrayObject
    {
        $activities = new \ArrayObject();
        try{
            $qb = $this->entityManager->getRepository(Activity::class)->createQueryBuilder('a');
            $qb->where($qb->expr()->eq('a.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->orderBy('a.position', 'ASC')
                ->addOrderBy('a.label', 'ASC');
            if(!is_null($type)){
                $qb->andWhere($qb->expr()->eq('a.type', ':type'))
                    ->setParameter('type', $type);
            }
            foreach ($qb->getQuery()->getResult() as $activity){
                $activities->append($activity);
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $activities;
    }

    /**
     * @param Activity $activity
     * @throws \Exception
     */
    public function update(Activity $activity): void
    {
        try{
            $this->entityManager->persist($activity);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Activity $activity
     * @throws \Exception
     */
    public function create(Activity $activity): void
    {
        try{
            $this->entityManager->persist($activity);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Activity $activity
     * @throws \Exception
     */
    public function delete(Activity $activity): void
    {
        try {
            $this->entityManager->remove($activity);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function findLikeQuery(string $query, string $type): array
    {

        return $this->entityManager->getRepository(Activity::class)->createQueryBuilder('a')
            ->andWhere('a.label LIKE :query ')
            ->andWhere('a.type = :type ')
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()
            ;
    }

}