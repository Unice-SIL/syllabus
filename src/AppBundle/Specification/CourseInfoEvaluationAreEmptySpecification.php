<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationMccAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEvaluationAreEmptySpecification extends Specification
{
    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        $courseInfoEvaluationMccAreEmptySpecification = new CourseInfoEvaluationMccAreEmptySpecification();
        $courseInfoEvaluationAdvicesAreEmptySpecification = new CourseInfoEvaluationAdvicesAreEmptySpecification();
        $courseInfoEvaluationMethodsAreEmptySpecification = new CourseInfoEvaluationMethodsAreEmptySpecification();
        return (
            $courseInfoEvaluationMccAreEmptySpecification->isSatisfiedBy($courseInfo) &&
            $courseInfoEvaluationAdvicesAreEmptySpecification->isSatisfiedBy($courseInfo) &&
            $courseInfoEvaluationMethodsAreEmptySpecification->isSatisfiedBy($courseInfo)
        );
    }
}