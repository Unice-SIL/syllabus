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
class FindCourseInfoByEtbIdAndYearQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var string
     */
    private $etbId;

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
     * @param string $etbId
     * @return FindCourseInfoByEtbIdAndYearQuery
     */
    public function setEtbId(string $etbId): FindCourseInfoByEtbIdAndYearQuery
    {
        $this->etbId = $etbId;
        return $this;
    }

    /**
     * @param string $year
     * @return FindCourseInfoByEtbIdAndYearQuery
     */
    public function setYear(string $year): FindCourseInfoByEtbIdAndYearQuery
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
            $courseInfo = $this->courseInfoRepository->findByEtbIdAndYear($this->etbId, $this->year);
            if(is_null($courseInfo)){
                throw new CourseInfoNotFoundException(sprintf("Course info with etablishment id %s for year %s not found", $this->etbId, $this->year));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseInfo;
    }
}