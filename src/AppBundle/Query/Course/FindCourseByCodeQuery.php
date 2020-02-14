<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\Course;
use AppBundle\Exception\CourseNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseRepositoryInterface;

/**
 * Class FindCourseByCodeQuery
 * @package AppBundle\Query\Course
 */
class FindCourseByCodeQuery implements QueryInterface
{

    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * @var string
     */
    private $code;

    /**
     * FindCourseByCodeQuery constructor.
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(
        CourseRepositoryInterface $courseRepository
    )
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param string $code
     * @return FindCourseByCodeQuery
     */
    public function setCode(string $code): FindCourseByCodeQuery
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return Course|null
     * @throws \Exception
     */
    public function execute(): ?Course
    {
        $course = null;
        try{
            $course = $this->courseRepository->findByCode($this->code);
            if(is_null($course)){
                throw new CourseNotFoundException(sprintf("Course with establishment id %s not found", $this->code));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $course;
    }
}