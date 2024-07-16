<?php


namespace App\Syllabus\Manager;


use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use App\Syllabus\Repository\Doctrine\StatisticSyllabusDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use function GuzzleHttp\Psr7\str;

class StatisticSyllabusManager
{
    /**
     * @var StatisticSyllabusDoctrineRepository
     */
    private StatisticSyllabusDoctrineRepository $repository;

    /**
     * @var CourseInfoDoctrineRepository
     */
    private CourseInfoDoctrineRepository $courseInfoDoctrineRepository;

    /**
     * StatisticSyllabusManager constructor.
     * @param StatisticSyllabusDoctrineRepository $repository
     * @param CourseInfoDoctrineRepository $courseInfoDoctrineRepository
     */
    public function __construct(StatisticSyllabusDoctrineRepository $repository,
                                CourseInfoDoctrineRepository $courseInfoDoctrineRepository)
    {
        $this->repository = $repository;
        $this->courseInfoDoctrineRepository = $courseInfoDoctrineRepository;
    }

    /**
     * @param string $year
     * @return mixed
     */
    public function findSyllabusPublished(string $year): mixed
    {
        return $this->repository->getSyllabusPublished($year);
    }

    /**
     * @param string $year
     * @return mixed
     */
    public function findSyllabusBeingFilled(string $year): mixed
    {
        return $this->repository->getSyllabusBeingFilled($year);
    }

    /**
     * @param string $year
     * @return array
     * @throws Exception
     */
    public function findSyllabusByYear(string $year): array
    {
        return $this->courseInfoDoctrineRepository->findByYear($year);
    }
}