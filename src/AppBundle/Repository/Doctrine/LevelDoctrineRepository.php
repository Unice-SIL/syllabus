<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\Level;
use AppBundle\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class LevelDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class LevelDoctrineRepository extends ServiceEntityRepository
{
    /**
     * LevelDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Level::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Level::class)
            ->createQueryBuilder('l')
            ->addOrderBy('l.label', 'ASC');
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query, string $field = 'label'): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere('l.label LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $query
     * @param Structure $structure
     * @param string $field
     * @return array
     */
    public function findLikeWithStructureQuery(string $query, Structure $structure, string $field = 'label'): array
    {
        $qb = $this->getIndexQueryBuilder();
        if (in_array($field, ['label'])) {
            $qb->andWhere('l.label LIKE :query ')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->andWhere(':structure MEMBER OF l.structures')
            ->setParameter('structure', $structure)
            ->getQuery()
            ->getResult();
    }


}