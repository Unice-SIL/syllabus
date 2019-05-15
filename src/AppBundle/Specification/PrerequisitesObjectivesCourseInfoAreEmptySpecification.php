<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class PrerequisitesObjectivesCourseInfoAreEmptySpecification
 * @package AppBundle\Specification
 */
class PrerequisitesObjectivesCourseInfoAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if($courseInfo->getCoursePrerequisites()->count() == 0){
            return true;
        }
        return false;
    }
}