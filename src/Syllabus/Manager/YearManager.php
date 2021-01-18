<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\Year;
use App\Syllabus\Repository\Doctrine\YearDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class YearManager
 * @package AppBundle\Manager
 */
class YearManager
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var YearDoctrineRepository
     */
    private $repository;

    /**
     * YearManager constructor.
     * @param EntityManagerInterface $em
     * @param YearDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, YearDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Year
     */
    public function new()
    {
        return new Year();
    }

    /**
     * @param $id
     * @return Year|null
     */
    public function find($id): ?Year
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
     * @return Year|null
     */
    public function findCurrentYear(): ?Year
    {
        return $this->repository->findOneBy(['current' => 1]);
    }

    /**
     * @return array
     */
    public function findToImport(): array
    {
        return $this->repository->findBy(['import' => 1]);
    }

    /**
     * @param Year $year
     */
    public function create(Year $year): void
    {
        $this->em->persist($year);
        $this->em->flush();
    }

    /**
     * @param Year $year
     */
    public function update(Year $year): void
    {
        if ($year->getCurrent())
        {
            $currentYears = $this->repository->findBy(['current' => 1]);
            foreach ($currentYears as $currentYear)
            {
                $currentYear->setCurrent(false);
            }
            $year->setCurrent(true);
        }
        $this->em->flush();
    }

    /**
     * @param Year $year
     */
    public function delete(Year $year)
    {
        $this->em->remove($year);
        $this->em->flush();
    }
}