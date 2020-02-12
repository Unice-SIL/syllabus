<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CoursePermission;
use AppBundle\Repository\CoursePermissionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class StructureDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CoursePermissionDoctrineRepository  extends AbstractDoctrineRepository implements CoursePermissionRepositoryInterface
{

    /**
     * StructureDoctrineRepository constructor.
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
     * @return CoursePermission|null
     * @throws \Exception
     */
    public function find(string $id): ?CoursePermission
    {
        $permission = null;
        try{
            $permission = $this->entityManager->getRepository(CoursePermission::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $permission;
    }


    /**
     * @param CoursePermission $permission
     * @throws \Exception
     */
    public function create(CoursePermission $permission): void
    {
        try{
            $this->entityManager->persist($permission);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param CoursePermission $permission
     * @throws \Exception
     */
    public function update(CoursePermission $permission): void
    {
        try{
            $this->entityManager->persist($permission);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->entityManager->getRepository(CoursePermission::class)
            ->createQueryBuilder('cp')
            ->innerJoin('cp.user', 'u')
            ->addSelect('u')
            ->addOrderBy('cp.permission', 'ASC')
            ;
    }

    public function findQueryBuilderForApi(array $config): QueryBuilder
    {
        $qb = $this->getIndexQueryBuilder();

        foreach ($config['filters'] as $filter => $value) {
            $valueName = 'value'.$filter;
            switch ($filter) {
                case 'permission':
                    $qb->andWhere($qb->expr()->eq('cp.permission', ':'.$valueName))
                        ->setParameter($valueName, $value)
                    ;
                    break;
                case 'userId':
                    $qb->andWhere($qb->expr()->eq('u.id', ':'.$valueName))
                        ->setParameter($valueName, $value)
                    ;
                    break;
            }
        }

        return $qb;
    }

}