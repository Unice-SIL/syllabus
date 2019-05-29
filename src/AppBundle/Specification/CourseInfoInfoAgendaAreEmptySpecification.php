<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoInfoAgendaAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoInfoAgendaAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if(
            is_null($courseInfo->getAgenda())
        ){
            return true;
        }
        return false;
    }
}