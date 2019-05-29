<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoObjectivesPrerequisitesAreNotEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoObjectivesPrerequisitesAreEmptySpecification extends Specification
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