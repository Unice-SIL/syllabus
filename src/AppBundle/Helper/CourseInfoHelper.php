<?php

namespace AppBundle\Helper;

use AppBundle\Entity\CourseInfo;
use AppBundle\Specification\AchievementsObjectivesCourseInfoAreEmptySpecification;
use AppBundle\Specification\CanBePublishedCourseInfoSpecification;
use AppBundle\Specification\ObjectivesCourseInfoAreEmptySpecification;
use AppBundle\Specification\PrerequisitesObjectivesCourseInfoAreEmptySpecification;
use AppBundle\Specification\TutoringInfoObjectivesCourseInfoAreEmptySpecification;
use AppBundle\Specification\TutoringObjectivesCourseInfoAreEmptySpecification;

/**
 * Class CourseInfoHelper
 * @package AppBundle\Helper
 */
class CourseInfoHelper
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function canBePublished(CourseInfo $courseInfo){
        $canBePublishedCourseInfoSpecification = new CanBePublishedCourseInfoSpecification();
        return $canBePublishedCourseInfoSpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function objectivesInfoAreEmpty(CourseInfo $courseInfo){
        $objectivesCourseInfoAreEmptySpecification = new ObjectivesCourseInfoAreEmptySpecification();
        return $objectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function AchievementsObjectivesInfoAreEmpty(CourseInfo $courseInfo){
        $achievementsObjectivesCourseInfoAreEmptySpecification = new AchievementsObjectivesCourseInfoAreEmptySpecification();
        return $achievementsObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function PrerequisitesObjectivesInfoAreEmpty(CourseInfo $courseInfo){
        $prerequisitesObjectivesCourseInfoAreEmptySpecification = new PrerequisitesObjectivesCourseInfoAreEmptySpecification();
        return $prerequisitesObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function TutoringObjectivesInfoAreEmpty(CourseInfo $courseInfo){
        $tutoringObjectivesCourseInfoAreEmptySpecification = new TutoringObjectivesCourseInfoAreEmptySpecification();
        return $tutoringObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function TutoringInfoObjectivesInfoAreEmpty(CourseInfo $courseInfo){
        $tutoringInfoObjectivesCourseInfoAreEmptySpecification = new TutoringInfoObjectivesCourseInfoAreEmptySpecification();
        return $tutoringInfoObjectivesCourseInfoAreEmptySpecification->isSatisfiedBy($courseInfo);
    }
}