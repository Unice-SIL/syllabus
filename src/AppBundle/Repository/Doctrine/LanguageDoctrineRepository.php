<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class LanguageDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class LanguageDoctrineRepository extends ServiceEntityRepository
{
    /**
     * LanguageDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Language::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(Language::class)
            ->createQueryBuilder('l')
            ->addOrderBy('l.label', 'ASC');
    }

    /**
     * @param string $query
     * @param string $field
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
     * @param array $filters
     * @return array
     */
    public function findByFilters($filters=[]): array
    {
        return $this->findQueryBuilderForApi(['filters' => $filters])->getQuery()->getResult();
    }

    /**
     * @param array $config
     * @return QueryBuilder
     */
    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter){
                case 'label':
                    $qb->andWhere($qb->expr()->like('l.' . $filter, ':' . $valueName));
                    $value = "%{$value}%";
                    break;
                default:
                    $qb->andWhere($qb->expr()->eq('l.' . $filter, ':' . $valueName));
            }
            $qb->setParameter($valueName, $value);
        }

        return $qb;
    }
}