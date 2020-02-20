<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\CriticalAchievement;
use AppBundle\Repository\CriticalAchievementRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class CriticalAchievementDoctrineRepository extends AbstractDoctrineRepository implements CriticalAchievementRepositoryInterface
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
     * @return object
     * @throws \Exception
     */
    public function find(string $id): CriticalAchievement
    {
        $criticalAchievement = null;
        try{
            $criticalAchievement = $this->entityManager->getRepository(CriticalAchievement::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $criticalAchievement;
    }

    /**
     * @return \ArrayObject|mixed
     * @throws \Exception
     */
    public function findAll()
    {
        $criticalAchievements = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(CriticalAchievement::class)->createQueryBuilder('ca');
            $qb->where($qb->expr()->eq('ca.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->addOrderBy('ca.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $criticalAchievement){
                $criticalAchievements->append($criticalAchievement);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $criticalAchievements;
    }


    /**
     * @param CriticalAchievement $criticalAchievement
     * @throws \Exception
     */
    public function update(CriticalAchievement $criticalAchievement): void
    {
        try{
            $this->entityManager->persist($criticalAchievement);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param CriticalAchievement $criticalAchievement
     * @throws \Exception
     */
    public function create(CriticalAchievement $criticalAchievement): void
    {
        try{
            $this->entityManager->persist($criticalAchievement);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param CriticalAchievement $criticalAchievement
     * @throws \Exception
     */
    public function delete(CriticalAchievement $criticalAchievement): void
    {
        try {
            $this->entityManager->remove($criticalAchievement);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(CriticalAchievement::class)->createQueryBuilder('ca')
            ->andWhere('ca.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }
}