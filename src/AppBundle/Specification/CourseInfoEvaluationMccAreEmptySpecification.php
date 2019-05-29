<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationMccAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEvaluationMccAreEmptySpecification extends Specification
{
    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            is_null($courseInfo->getMccCcCoeffSession1()) &&
            is_null($courseInfo->getMccCcNbEvalSession1()) &&
            is_null($courseInfo->getMccCtCoeffSession1()) &&
            is_null($courseInfo->getMccCtNatSession1()) &&
            is_null($courseInfo->getMccCtDurationSession1()) &&
            is_null($courseInfo->getMccCtCoeffSession2()) &&
            is_null($courseInfo->getMccCtNatSession2()) &&
            is_null($courseInfo->getMccCtDurationSession2())
        ){
            return true;
        }
        return false;
    }
}