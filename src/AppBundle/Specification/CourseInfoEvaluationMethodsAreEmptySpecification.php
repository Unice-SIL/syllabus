<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationMethodsAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEvaluationMethodsAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        $courseInfoEvaluationCcAreEmptySpecification = new CourseInfoEvaluationCcAreEmptySpecification();
        if(
            $courseInfoEvaluationCcAreEmptySpecification->isSatisfiedBy($courseInfo)
        ){
            return true;
        }
        return false;
    }
}