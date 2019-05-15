<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationCtAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEvaluationCtAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if($courseInfo->getCourseEvaluationCts()->count() == 0){
            return true;
        }
        return false;
    }
}