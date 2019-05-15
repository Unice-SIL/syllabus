<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class TutoringObjectivesCourseInfoAreEmptySpecification
 * @package AppBundle\Specification
 */
class TutoringObjectivesCourseInfoAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        $tutoringInfoObjectivesCourseInfoAreEmptySpecification = new TutoringInfoObjectivesCourseInfoAreEmptySpecification();
        if(
            $courseInfo->getCourseTutoringResources()->count() == 0 &&
            $tutoringInfoObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo)
        ){
            return true;
        }
        return false;
    }
}