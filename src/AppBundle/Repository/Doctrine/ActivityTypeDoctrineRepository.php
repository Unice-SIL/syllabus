<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\ActivityType;
use AppBundle\Repository\ActivityTypeRepositoryInterface;

/**
 * Class ActivityTypeDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class ActivityTypeDoctrineRepository extends AbstractDoctrineRepository implements ActivityTypeRepositoryInterface
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function findAll()
    {
        $activityTypes = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(ActivityType::class)->createQueryBuilder('at');
            $qb->where($qb->expr()->eq('at.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->orderBy('at.position', 'ASC')
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
}