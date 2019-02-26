<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;

/**
 * Class FindCourseInfoByIdAndYearQuery
 * @package AppBundle\Query\Course
 */
class FindCourseInfoByIdAndYearQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $year;

    /**
     * FindCourseInfoByIdAndYearQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
    }

    /**
     * @param string $id
     * @return FindCourseInfoByIdAndYearQuery
     */
    public function setId(string $id): FindCourseInfoByIdAndYearQuery
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $year
     * @return FindCourseInfoByIdAndYearQuery
     */
    public function setYear(string $year): FindCourseInfoByIdAndYearQuery
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
            $courseInfo = $this->courseInfoRepository->findByIdAndYear($this->id, $this->year);
            if(is_null($courseInfo)){
                throw new CourseInfoNotFoundException(sprintf("Course info with id %s not found", $this->id));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseInfo;
    }
}