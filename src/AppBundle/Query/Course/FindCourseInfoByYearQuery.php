<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;

/**
 * Class FindCourseInfoByYearQuery
 * @package AppBundle\Query\Course
 */
class FindCourseInfoByYearQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var string
     */
    private $year;

    /**
     * FindCourseInfoByIdQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
    }

    /**
     * @param string $year
     * @return FindCourseInfoByEtbIdAndYearQuery
     */
    public function setYear(string $year): FindCourseInfoByYearQuery
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function execute(): array
    {
        $coursesInfo = [];
        try{
            $coursesInfo = $this->courseInfoRepository->findByYear($this->year);
        }catch (\Exception $e){
            throw $e;
        }
        return $coursesInfo;
    }
}