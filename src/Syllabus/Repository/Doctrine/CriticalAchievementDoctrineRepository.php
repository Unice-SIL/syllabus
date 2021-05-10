<?php


namespace App\Syllabus\Repository\Doctrine;


use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CriticalAchievement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class CriticalAchievementDoctrineRepository extends ServiceEntityRepository
{
    /**
     * CriticalAchievementDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CriticalAchievement::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(CriticalAchievement::class)
            ->createQueryBuilder('ca')
            ->addOrderBy('ca.label', 'ASC');
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->getIndexQueryBuilder()
            ->andWhere('ca.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string|null $query
     * @param Course $course
     * @return array
     */
    public function findLikeQueryByCourse(string $query, Course $course): array
    {
        $qb = $this->getIndexQueryBuilder()
            ->andWhere('ca.label LIKE :query ')
            ->andWhere(':course MEMBER OF ca.courses' )
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('course', $course);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder()->innerJoin('ca.courses', 'c');

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter) {
                case 'courseId':
                    $qb->andWhere($qb->expr()->eq('c.id', ':'.$valueName));
                    break;
                case 'label':
                    $value = "%{$value}%";
                    $qb->andWhere($qb->expr()->like('ca.' . $filter, ':' . $valueName));
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('ca.' . $filter, ':' . $valueName));
                    break;
            }
            $qb->setParameter($valueName, $value);
        }
        return $qb;
    }
}