<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\Course;
use AppBundle\Exception\CourseNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseRepositoryInterface;

/**
 * Class FindCourseByEtbIdQuery
 * @package AppBundle\Query\Course
 */
class FindCourseByEtbIdQuery implements QueryInterface
{

    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * @var string
     */
    private $etbId;

    /**
     * FindCourseByEtbIdQuery constructor.
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(
        CourseRepositoryInterface $courseRepository
    )
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param string $etbId
     * @return FindCourseByEtbIdQuery
     */
    public function setEtbId(string $etbId): FindCourseByEtbIdQuery
    {
        $this->etbId = $etbId;
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
            $course = $this->courseRepository->findByEtbId($this->etbId);
            if(is_null($course)){
                throw new CourseNotFoundException(sprintf("Course with establishment id %s not found", $this->etbId));
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $course;
    }
}