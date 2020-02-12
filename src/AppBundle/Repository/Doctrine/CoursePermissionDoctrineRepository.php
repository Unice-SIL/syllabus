<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\User;
use AppBundle\Repository\CoursePermissionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StructureDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CoursePermissionDoctrineRepository extends AbstractDoctrineRepository implements CoursePermissionRepositoryInterface
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
     * @return mixed
     */
    public function getCourseBypermission(User $user)
    {
        $qb = $this->entityManager->getRepository(CourseInfo::class)->createQueryBuilder('ci');
            $qb->join('ci.coursePermissions', 'cp')
                ->where($qb->expr()->eq('cp.user', ':user'))
                ->setParameter('user', $user);
            $courseInfos = $qb->getQuery()->getResult();

            return $courseInfos;
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

}