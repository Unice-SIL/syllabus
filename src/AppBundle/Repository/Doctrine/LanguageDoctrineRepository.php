<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\Language;
use AppBundle\Repository\LanguageRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @property EntityManagerInterface entityManager
 */
class LanguageDoctrineRepository extends AbstractDoctrineRepository implements LanguageRepositoryInterface
{
    /**
     * LanguageDoctrineRepository constructor.
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
     * @return Language|null
     * @throws \Exception
     */
    public function find(string $id): ?Language
    {
        $language = null;
        try{
            $language = $this->entityManager->getRepository(Language::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $language;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findAll(): \ArrayObject
    {
        $languages = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(Language::class)->createQueryBuilder('l');
            $qb->where($qb->expr()->eq('l.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->addOrderBy('l.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $language){
                $languages->append($language);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $languages;
    }

    /**
     * @param Language $language
     * @throws \Exception
     */
    public function create(Language $language): void
    {
        try{
            $this->entityManager->persist($language);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Language $language
     * @throws \Exception
     */
    public function update(Language $language): void
    {
        try{
            $this->entityManager->persist($language);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Delete Language
     * @param Language $language
     */
    public function delete(Language $language): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Language::class)
            ->createQueryBuilder('l')
            ->addOrderBy('l.label', 'ASC')
            ;
    }

    /**
     * @param string $query
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(Language::class)->createQueryBuilder('l')
            ->andWhere('l.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            $qb->andWhere($qb->expr()->eq($qb->getRootAlias() . '.' . $filter, ':' . $valueName))
                ->setParameter($valueName, $value)
            ;
        }

        return $qb;
    }
}