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
     * ActivityTypeDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \ArrayObject|mixed
     * @throws \Exception
     */
    public function findAll()
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
}