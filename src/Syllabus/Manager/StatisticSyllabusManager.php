<?php


namespace App\Syllabus\Manager;


use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use App\Syllabus\Repository\Doctrine\StatisticSyllabusDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use function GuzzleHttp\Psr7\str;

class StatisticSyllabusManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var StatisticSyllabusDoctrineRepository
     */
    private $repository;

    /**
     * @var CourseInfoDoctrineRepository
     */
    private $courseInfoDoctrineRepository;

    /**
     * StatisticSyllabusManager constructor.
     * @param EntityManagerInterface $em
     * @param StatisticSyllabusDoctrineRepository $repository
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     */
    public function __construct(EntityManagerInterface $em, StatisticSyllabusDoctrineRepository $repository,
                                CourseInfoDoctrineRepository $courseInfoDoctrineRepository)
    {
        $this->em = $em;
        $this->repository = $repository;
        $this->courseInfoDoctrineRepository = $courseInfoDoctrineRepository;
    }

    /**
     * @param string $year
     * @return mixed
     */
    public function findSyllabusPublished(string $year)
    {
        return $this->repository->getSyllabusPublished($year);
    }

    /**
     * @param string $year
     * @return mixed
     */
    public function findSyllabusBeingFilled(string $year)
    {
        return $this->repository->getSyllabusBeingFilled($year);
    }

    /**
     * @param string $year
     * @return array
     * @throws \Exception
     */
    public function findSyllabusByYear(string $year)
    {
        return $this->courseInfoDoctrineRepository->findByYear($year);
    }
}