<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoInfoOrganizationAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoInfoOrganizationAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            is_null($courseInfo->getOrganization())
        ){
            return true;
        }
        return false;
    }
}