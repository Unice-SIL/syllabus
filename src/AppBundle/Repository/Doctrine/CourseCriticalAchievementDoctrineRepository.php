<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\CourseCriticalAchievement;
use AppBundle\Repository\CourseCriticalAchievementRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class CourseCriticalAchievementDoctrineRepository extends AbstractDoctrineRepository implements CourseCriticalAchievementRepositoryInterface
{

    /**
     * CourseCriticalAchievementDoctrineRepository constructor.
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
     * @return object
     * @throws \Exception
     */
    public function find(string $id)
    {
        $courseCriticalAchievement = null;
        try{
            $courseCriticalAchievement = $this->entityManager->getRepository(CourseCriticalAchievement::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $courseCriticalAchievement;
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $courseCriticalAchievements = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(CourseCriticalAchievement::class)->createQueryBuilder('cca');
            $qb->where($qb->expr()->eq('cca.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->addOrderBy('cca.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $courseCriticalAchievement){
                $courseCriticalAchievements->append($courseCriticalAchievement);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $courseCriticalAchievements;
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function update(CourseCriticalAchievement $courseCriticalAchievement): void
    {
        // TODO: Implement update() method.
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function create(CourseCriticalAchievement $courseCriticalAchievement): void
    {
        // TODO: Implement create() method.
    }

    /**
     * @param CourseCriticalAchievement $courseCriticalAchievement
     */
    public function delete(CourseCriticalAchievement $courseCriticalAchievement): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        // TODO: Implement findLikeQuery() method.
    }
}