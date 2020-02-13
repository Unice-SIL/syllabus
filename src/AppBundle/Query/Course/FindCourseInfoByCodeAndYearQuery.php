<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;

/**
 * Class FindCourseInfoByIdQuery
 * @package AppBundle\Query\Course
 */
class FindCourseInfoByCodeAndYearQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var string
     */
    private $code;

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
     * @param string $code
     * @return FindCourseInfoByCodeAndYearQuery
     */
    public function setCode(string $code): FindCourseInfoByCodeAndYearQuery
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $year
     * @return FindCourseInfoByCodeAndYearQuery
     */
    public function setYear(string $year): FindCourseInfoByCodeAndYearQuery
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return CourseInfo|null
     * @throws \Exception
     */
    public function execute(): ?CourseInfo
    {
        $courseInfo = null;
        try{
            $courseInfo = $this->courseInfoRepository->findByCodeAndYear($this->code, $this->year);
            if(is_null($courseInfo)){
                throw new CourseInfoNotFoundException(sprintf("CourseInfo with establishment id %s for year %s not found.", $this->code, $this->year));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseInfo;
    }
}