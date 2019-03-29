<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Repository\CourseTutoringResourceRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CourseTutoringResourceDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class CourseTutoringResourceDoctrineRepository extends AbstractDoctrineRepository implements CourseTutoringResourceRepositoryInterface
{

    /**
     * CourseTutoringResourceDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @return CourseTutoringResource|null
     * @throws \Exception
     */
    public function find(string $id): ?CourseTutoringResource
    {
        $courseTutoringResource = null;
        try{
            $courseTutoringResource = $this->entityManager->getRepository(CourseTutoringResource::class)->find($id);
            return $courseTutoringResource;
        }catch (\Exception $e){
            throw $e;
        }
    }


    /**
     * @param CourseTutoringResource $courseTutoringResource
     * @throws \Exception
     */
    public function create(CourseTutoringResource $courseTutoringResource): void
    {
        try{
            $this->entityManager->persist($courseTutoringResource);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param CourseTutoringResource $courseTutoringResource
     * @throws \Exception
     */
    public function delete(CourseTutoringResource $courseTutoringResource): void
    {
        try {
            $this->entityManager->remove($courseTutoringResource);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}