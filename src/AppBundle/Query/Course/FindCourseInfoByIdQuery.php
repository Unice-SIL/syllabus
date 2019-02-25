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
class FindCourseInfoByIdQuery implements QueryInterface
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
     * @param string $id
     * @return FindCourseInfoByIdQuery
     */
    public function setId(string $id): FindCourseInfoByIdQuery
    {
        $this->id = $id;
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
            $courseInfo = $this->courseInfoRepository->find($this->id);
            if(is_null($courseInfo)){
                throw new CourseInfoNotFoundException(sprintf("Course info with id %s not found", $this->id));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseInfo;
    }
}