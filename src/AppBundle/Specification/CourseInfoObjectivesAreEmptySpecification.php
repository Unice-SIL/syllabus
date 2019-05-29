<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoObjectivesAreNotEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoObjectivesAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        $courseInfoObjectivesAchievementsAreEmptySpecification = new CourseInfoObjectivesAchievementsAreEmptySpecification();
        $courseInfoObjectivesPrerequisitesAreEmptySpecification = new CourseInfoObjectivesPrerequisitesAreEmptySpecification();
        $courseInfoObjectivesTutoringAreEmptySpecification = new CourseInfoObjectivesTutoringAreEmptySpecification();
        return (
            $courseInfoObjectivesAchievementsAreEmptySpecification->isSatisfiedBy($courseInfo) &&
            $courseInfoObjectivesPrerequisitesAreEmptySpecification->isSatisfiedBy($courseInfo) &&
            $courseInfoObjectivesTutoringAreEmptySpecification->isSatisfiedBy($courseInfo)
        );
    }
}