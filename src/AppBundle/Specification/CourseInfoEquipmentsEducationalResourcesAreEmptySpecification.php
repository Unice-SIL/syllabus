<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationAdvicesAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEquipmentsEducationalResourcesAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            is_null($courseInfo->getEducationalResources())
        ){
            return true;
        }
        return false;
    }
}