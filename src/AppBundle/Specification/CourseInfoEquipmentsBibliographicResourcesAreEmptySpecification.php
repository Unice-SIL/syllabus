<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationAdvicesAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEquipmentsBibliographicResourcesAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            is_null($courseInfo->getBibliographicResources())
        ){
            return true;
        }
        return false;
    }
}