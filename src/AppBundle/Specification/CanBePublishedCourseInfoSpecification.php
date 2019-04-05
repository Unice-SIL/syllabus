<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CanBePublishedCourseInfoSpecification
 * @package AppBundle\Specification
 */
class CanBePublishedCourseInfoSpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        return (
            $courseInfo->isTemPresentationTabValid() &&
            $courseInfo->isTemActivitiesTabValid() &&
            $courseInfo->isTemObjectivesTabValid() &&
            $courseInfo->isTemMccTabValid() &&
            $courseInfo->isTemEquipmentsTabValid() &&
            $courseInfo->isTemInfosTabValid() &&
            $courseInfo->isTemClosingRemarksTabValid() &&
            is_null($courseInfo->getPublicationDate())
        );
    }
}