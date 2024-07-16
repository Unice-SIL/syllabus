<?php


namespace App\Syllabus\Manager;


use App\Syllabus\Entity\Period;
use App\Syllabus\Repository\Doctrine\PeriodDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PeriodManager
 * @package App\Syllabus\Manager
 */
class PeriodManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var PeriodDoctrineRepository
     */
    private PeriodDoctrineRepository $repository;

    public function __construct(EntityManagerInterface $em, PeriodDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Period
     */
    public function new(): Period
    {
        return new Period();
    }

    /**
     * @param $id
     * @return Period|null
     */
    public function find($id): ?Period
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
     * @param Period $period
     */
    public function create(Period $period): void
    {
        $this->em->persist($period);
        $this->em->flush();
    }

    /**
     * @param Period $period
     */
    public function update(Period $period): void
    {
        $this->em->flush();
    }

    /**
     * @param Period $period
     */
    public function delete(Period $period): void
    {
        $this->em->remove($period);
        $this->em->flush();
    }
}