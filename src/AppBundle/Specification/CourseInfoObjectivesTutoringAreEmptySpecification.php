<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoObjectivesTutoringAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoObjectivesTutoringAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        $courseInfoObjectivesTutoringResourcesAreEmptySpecification = new CourseInfoObjectivesTutoringResourcesAreEmptySpecification();
        $courseInfoObjectivesTutoringInfoAreEmptySpecification = new CourseInfoObjectivesTutoringInfoAreEmptySpecification();
        if(
            $courseInfoObjectivesTutoringResourcesAreEmptySpecification->isSatisfiedBy($courseInfo) &&
            $courseInfoObjectivesTutoringInfoAreEmptySpecification->isSatisfiedBy($courseInfo)
        ){
            return true;
        }
        return false;
    }
}