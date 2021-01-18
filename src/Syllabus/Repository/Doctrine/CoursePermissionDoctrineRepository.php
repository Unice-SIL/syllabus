<?php

namespace App\Syllabus\Repository\Doctrine;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class StructureDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CoursePermissionDoctrineRepository extends ServiceEntityRepository
{
    /**
     * CoursePermissionDoctrineRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CoursePermission::class);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getCourseByPermission(User $user)
    {
        $qb = $this->_em->getRepository(CourseInfo::class)->createQueryBuilder('ci');
        $qb->join('ci.coursePermissions', 'cp')
            ->where($qb->expr()->eq('cp.user', ':user'))
            ->setParameter('user', $user);
        $courseInfos = $qb->getQuery()->getResult();

        return $courseInfos;
    }

    /**
     * @return QueryBuilder
     */
    public function getIndexQueryBuilder(): QueryBuilder
    {
        return $this->_em->getRepository(CoursePermission::class)
            ->createQueryBuilder('cp')
            ->innerJoin('cp.user', 'u')
            ->addSelect('u')
            ->addOrderBy('cp.permission', 'ASC');
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
            switch ($filter) {
                case 'permission':
                    $qb->andWhere($qb->expr()->eq('cp.permission', ':'.$valueName))
                        ->setParameter($valueName, $value);
                    break;
                case 'userId':
                    $qb->andWhere($qb->expr()->eq('u.id', ':'.$valueName))
                        ->setParameter($valueName, $value);
                    break;
            }
        }
        return $qb;
    }

}