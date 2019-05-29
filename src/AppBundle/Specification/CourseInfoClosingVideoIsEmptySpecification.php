<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoClosingVideoIsEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoClosingVideoIsEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            is_null($courseInfo->getClosingVideo())
        ){
            return true;
        }
        return false;
    }
}