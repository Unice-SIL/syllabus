<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoObjectivesTutoringAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoObjectivesTutoringResourcesAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            $courseInfo->getCourseTutoringResources()->count() == 0
        ){
            return true;
        }
        return false;
    }
}