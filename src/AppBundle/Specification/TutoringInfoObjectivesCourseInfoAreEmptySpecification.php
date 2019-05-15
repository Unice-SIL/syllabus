<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class TutoringInfoObjectivesCourseInfoAreEmptySpecification
 * @package AppBundle\Specification
 */
class TutoringInfoObjectivesCourseInfoAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            !$courseInfo->isTutoring() ||
            (
                $courseInfo->isTutoring() &&
                $courseInfo->isTutoringTeacher() == false &&
                $courseInfo->isTutoringStudent() == false &&
                is_null($courseInfo->getTutoringDescription())
            )
        ){
            return true;
        }
        return false;
    }
}