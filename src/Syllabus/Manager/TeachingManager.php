<?php


namespace App\Syllabus\Manager;


use App\Syllabus\Entity\Teaching;
use App\Syllabus\Repository\Doctrine\TeachingDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class TeachingManager
 * @package AppBundle\Manager
 */
class TeachingManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var TeachingDoctrineRepository
     */
    private $repository;

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
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param Teaching $teaching
     */
    public function create(Teaching $teaching)
    {
        $this->em->persist($teaching);
        $this->em->flush();
    }

    /**
     * @param Teaching $teaching
     */
    public function update(Teaching $teaching)
    {
        $this->em->flush();
    }

    /**
     * @param Teaching $teaching
     */
    public function delete(Teaching $teaching)
    {
        $this->em->remove($teaching);
        $this->em->flush();
    }
}