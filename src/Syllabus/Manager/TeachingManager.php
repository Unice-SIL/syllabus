<?php


namespace App\Syllabus\Manager;


use App\Syllabus\Entity\Teaching;
use App\Syllabus\Repository\Doctrine\TeachingDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class TeachingManager
 * @package App\Syllabus\Manager
 */
class TeachingManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var TeachingDoctrineRepository
     */
    private TeachingDoctrineRepository $repository;

    /**
     * TeachingManager constructor.
     * @param EntityManagerInterface $em
     * @param TeachingDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, TeachingDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @param string|null $type
     * @param float|null $hourlyVolume
     * @param string|null $mode
     * @return Teaching
     */
    public function new(string $type  = null, float $hourlyVolume = null, string $mode = null): Teaching
    {
        return new Teaching($type, $hourlyVolume, $mode);
    }

    /**
     * @param $id
     * @return Teaching|null
     */
    public function find($id): ?Teaching
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
     * @param Teaching $teaching
     */
    public function create(Teaching $teaching): void
    {
        $this->em->persist($teaching);
        $this->em->flush();
    }

    /**
     * @param Teaching $teaching
     */
    public function update(Teaching $teaching): void
    {
        $this->em->flush();
    }

    /**
     * @param Teaching $teaching
     */
    public function delete(Teaching $teaching): void
    {
        $this->em->remove($teaching);
        $this->em->flush();
    }
}