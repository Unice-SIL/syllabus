<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Activity;
use AppBundle\Repository\ActivityRepositoryInterface;
use Doctrine\ORM\EntityManager;

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
        EntityManager $entityManager
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
                ->orderBy('a.ord', 'ASC')
                ->addOrderBy('a.label', 'ASC');
            if(!is_null($type)){
                $qb->andWhere($qb->expr()->eq('a.type', ':type'))
                    ->setParameter('type', $type);
            }
            if(!is_null($mode)){
                $qb->andWhere($qb->expr()->eq('a.mode', ':mode'))
                    ->setParameter('mode', $mode);
            }
            if(!is_null($grp)){
                $qb->andWhere($qb->expr()->eq('a.grp', ':grp'))
                    ->setParameter('grp', $grp);
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

}