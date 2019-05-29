<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationAdvicesAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEquipmentsEquipmentsAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if( $courseInfo->getCourseResourceEquipments()->count() == 0){
            return true;
        }
        return false;
    }
}