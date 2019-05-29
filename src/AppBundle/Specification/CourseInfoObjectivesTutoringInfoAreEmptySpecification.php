<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoObjectivesTutoringInfoAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoObjectivesTutoringInfoAreEmptySpecification extends Specification
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