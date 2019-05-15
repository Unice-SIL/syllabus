<?php

namespace AppBundle\Specification;

use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class AchievementsObjectivesCourseInfoAreEmptySpecification
 * @package AppBundle\Specification
 */
class AchievementsObjectivesCourseInfoAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        if($courseInfo->getCourseAchievements()->count() == 0){
            return true;
        }
        return false;
    }
}