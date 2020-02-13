<?php


namespace AppBundle\Repository\Doctrine;


use AppBundle\Entity\Domain;
use AppBundle\Repository\DomainRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class DomainDoctrineRepository extends AbstractDoctrineRepository implements DomainRepositoryInterface
{

    /**
     * DomainDoctrineRepository constructor.
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
     * @return Domain|null
     * @throws \Exception
     */
    public function find(string $id): ?Domain
    {
        $domain = null;
        try {
            $domain = $this->entityManager->getRepository(Domain::class)->find($id);
        } catch(\Exception $e) {
            throw $e;
        }
        return $domain;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findAll(): \ArrayObject
    {
        $domain = new \ArrayObject();
        try {
            foreach($this->entityManager->getRepository(Domain::class)
                        ->findBy([], ['label' => 'ASC']) as $domain) {
                $domain->append($domain);
            }
        } catch(\Exception $e) {
            throw $e;
        }
        return $domain;
    }

    /**
     * @param Domain $domain
     * @throws \Exception
     */
    public function create(Domain $domain): void
    {
        try {
            $this->entityManager->persist($domain);
            $this->entityManager->flush();
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Domain $domain
     * @throws \Exception
     */
    public function update(Domain $domain): void
    {
        try {
            $this->entityManager->persist($domain);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Domain $domain
     * @throws \Exception
     */
    public function delete(Domain $domain): void
    {
        try {
            $this->entityManager->remove($domain);
            $this->entityManager->flush();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Domain::class)
            ->createQueryBuilder('d')
            ->addOrderBy('d.label', 'ASC')
            ;
    }

    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query): array
    {
        return $this->entityManager->getRepository(Domain::class)->createQueryBuilder('d')
            ->andWhere('d.label LIKE :query ')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult()
            ;
    }
}