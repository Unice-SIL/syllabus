<?php

namespace AppBundle\Manager;

use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Repository\Doctrine\CourseTutoringResourceDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CourseTutoringResourceManager
 * @package AppBundle\Manager
 */
class CourseTutoringResourceManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var CourseTutoringResourceDoctrineRepository
     */
    private $repository;

    /**
     * CourseTutoringResourceManager constructor.
     * @param EntityManagerInterface $em
     * @param CourseTutoringResourceDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, CourseTutoringResourceDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return CourseTutoringResource
     */
    public function new()
    {
        return new CourseTutoringResource();
    }

    /**
     * @param string $id
     * @return CourseTutoringResource|null
     */
    public function find(string $id): ?CourseTutoringResource
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param CourseTutoringResource $courseTutoringResource
     */
    public function create(CourseTutoringResource $courseTutoringResource): void
    {
        $this->em->persist($courseTutoringResource);
        $this->em->flush();
    }

    /**
     * @param CourseTutoringResource $courseTutoringResource
     */
    public function update(CourseTutoringResource $courseTutoringResource): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseTutoringResource $courseTutoringResource
     */
    public function delete(CourseTutoringResource $courseTutoringResource): void
    {
        $this->em->remove($courseTutoringResource);
        $this->em->flush();
    }

}