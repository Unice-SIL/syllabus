<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class ObjectivesCourseInfoAreEmptySpecification
 * @package AppBundle\Specification
 */
class ObjectivesCourseInfoAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        $achievementsObjectivesCourseInfoAreEmptySpecification = new AchievementsObjectivesCourseInfoAreEmptySpecification();
        $prerequisitesObjectivesCourseInfoAreEmptySpecification = new PrerequisitesObjectivesCourseInfoAreEmptySpecification();
        $tutoringObjectivesCourseInfoAreEmptySpecification = new TutoringObjectivesCourseInfoAreEmptySpecification();
        return (
            $achievementsObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo) &&
            $prerequisitesObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo) &&
            $tutoringObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo)
        );
    }
}