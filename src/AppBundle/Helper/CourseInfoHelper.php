<?php

namespace AppBundle\Helper;

use AppBundle\Entity\CourseInfo;
use AppBundle\Specification\CanBePublishedCourseInfoSpecification;
use AppBundle\Specification\CourseInfoEvaluationAdvicesAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationMccAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationMethodsAreEmptySpecification;
use AppBundle\Specification\CourseInfoObjectivesAchievementsAreEmptySpecification;
use AppBundle\Specification\CourseInfoObjectivesAreEmptySpecification;
use AppBundle\Specification\CourseInfoObjectivesPrerequisitesAreEmptySpecification;
use AppBundle\Specification\CourseInfoObjectivesTutoringAreEmptySpecification;
use AppBundle\Specification\CourseInfoObjectivesTutoringInfoAreEmptySpecification;

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
    public function objectivesAreEmpty(CourseInfo $courseInfo){
        $courseInfoObjectivesAreEmptySpecification = new CourseInfoObjectivesAreEmptySpecification();
        return $courseInfoObjectivesAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function objectivesAchievementsAreEmpty(CourseInfo $courseInfo){
        $courseInfoObjectivesAchievementsAreEmptySpecification = new CourseInfoObjectivesAchievementsAreEmptySpecification();
        return $courseInfoObjectivesAchievementsAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function objectivesPrerequisitesAreEmpty(CourseInfo $courseInfo){
        $courseInfoObjectivesPrerequisitesAreEmptySpecification = new CourseInfoObjectivesPrerequisitesAreEmptySpecification();
        return $courseInfoObjectivesPrerequisitesAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function objectivesTutoringAreEmpty(CourseInfo $courseInfo){
        $courseInfoObjectivesTutoringAreEmptySpecification = new CourseInfoObjectivesTutoringAreEmptySpecification();
        return $courseInfoObjectivesTutoringAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function objectivesTutoringInfoAreEmpty(CourseInfo $courseInfo){
        $courseInfoObjectivesTutoringInfoAreEmptySpecification = new CourseInfoObjectivesTutoringInfoAreEmptySpecification();
        return $courseInfoObjectivesTutoringInfoAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function evaluationAreEmpty(CourseInfo $courseInfo){
        $courseInfoEvaluationAreEmptySpecification = new CourseInfoEvaluationAreEmptySpecification();
        return $courseInfoEvaluationAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function evaluationAdvicesAreEmpty(CourseInfo $courseInfo){
        $courseInfoEvaluationAdvicesAreEmptySpecification = new CourseInfoEvaluationAdvicesAreEmptySpecification();
        return $courseInfoEvaluationAdvicesAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function evaluationMethodsAreEmpty(CourseInfo $courseInfo){
        $courseInfoEvaluationMethodsAreEmptySpecification = new CourseInfoEvaluationMethodsAreEmptySpecification();
        return $courseInfoEvaluationMethodsAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function evaluationMccAreEmpty(CourseInfo $courseInfo){
        $courseInfoEvaluationMccAreEmptySpecification = new CourseInfoEvaluationMccAreEmptySpecification();
        return $courseInfoEvaluationMccAreEmptySpecification->isSatisfiedBy($courseInfo);
    }
}