<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationAdvicesAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEvaluationAdvicesAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            empty($courseInfo->getMccAdvice())
        ){
            return true;
        }
        return false;
    }
}