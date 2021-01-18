<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\Campus;
use App\Syllabus\Repository\CampusRepositoryInterface;
use App\Syllabus\Repository\Doctrine\CampusDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CampusManager
 * @package AppBundle\Manager
 */
class CampusManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CampusRepositoryInterface
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, CampusDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Campus
     */
    public function new()
    {
        return new Campus();
    }

    /**
     * @param $id
     * @return Campus|null
     */
    public function find($id): ?Campus
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
     * @param Campus $campus
     */
    public function create(Campus $campus): void
    {
        $this->em->persist($campus);
        $this->em->flush();
    }

    /**
     * @param Campus $campus
     */
    public function update(Campus $campus): void
    {
        $this->em->flush();
    }

    /**
     * @param Campus $campus
     */
    public function delete(Campus $campus): void
    {
        $this->em->remove($campus);
        $this->em->flush();
    }
}