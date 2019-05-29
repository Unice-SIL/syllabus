<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoInfoAgendaAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoClosingRemarksAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            is_null($courseInfo->getClosingRemarks())
        ){
            return true;
        }
        return false;
    }
}