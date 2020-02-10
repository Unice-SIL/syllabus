<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Structure;
use AppBundle\Repository\StructureRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class StructureDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class StructureDoctrineRepository  extends AbstractDoctrineRepository implements StructureRepositoryInterface
{

    /**
     * StructureDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \ArrayObject
     * @throws \Exception
     */
    public function findAll(): \ArrayObject
    {
        $structures = new \ArrayObject();
        try {
            $qb = $this->entityManager->getRepository(Structure::class)->createQueryBuilder('s');
            $qb->where($qb->expr()->eq('s.obsolete', ':obsolete'))
                ->setParameter('obsolete', false)
                ->addOrderBy('s.label', 'ASC');
            foreach ($qb->getQuery()->getResult() as $structure){
                $structures->append($structure);
            }
        } catch (\Exception $exception)
        {
            throw $exception;
        }

        return $structures;
    }

    /**
     * @param string $id
     * @return Structure|null
     * @throws \Exception
     */
    public function find(string $id): ?Structure
    {
        $structure = null;
        try{
            $structure = $this->entityManager->getRepository(Structure::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $structure;
    }

    /**
     * @param string $etbId
     * @return Structure|null
     * @throws \Exception
     */
    public function findByEtbId(string $etbId): ?Structure
    {
        $structure = null;
        try{
            $structure = $this->entityManager->getRepository(Structure::class)->findOneByEtbId($etbId);
        }catch (\Exception $e){
            throw $e;
        }
        return $structure;
    }

    /**
     * @param Structure $structure
     * @throws \Exception
     */
    public function create(Structure $structure): void
    {
        try{
            $this->entityManager->persist($structure);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Structure $structure
     * @throws \Exception
     */
    public function update(Structure $structure): void
    {
        try{
            $this->entityManager->persist($structure);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(Structure::class)
            ->createQueryBuilder('s')
            ->addOrderBy('s.etbId', 'ASC')
            ->addOrderBy('s.label', 'ASC')
            ->addOrderBy('s.campus', 'ASC')
            ;
    }


    /**
     * @param string $query
     * @param string $field
     * @return array
     */
    public function findLikeQuery(string $query, string $field): array
    {
        $qb = $this->getIndexQueryBuilder();

        if (in_array($field, ['etbId', 'label', 'campus'])) {
            $qb->andWhere($qb->getRootAlias().'.'.$field.' LIKE :query ')
                ->setParameter('query', '%' . $query . '%')
            ;
        }
        return $qb->getQuery()->getResult()
            ;
    }

}