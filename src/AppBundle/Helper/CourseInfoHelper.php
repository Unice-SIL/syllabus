<?php

namespace AppBundle\Helper;

use AppBundle\Entity\CourseInfo;
use AppBundle\Specification\CanBePublishedCourseInfoSpecification;
use AppBundle\Specification\CourseInfoClosingRemarksAreEmptySpecification;
use AppBundle\Specification\CourseInfoClosingVideoIsEmptySpecification;
use AppBundle\Specification\CourseInfoEquipmentsBibliographicResourcesAreEmptySpecification;
use AppBundle\Specification\CourseInfoEquipmentsEducationalResourcesAreEmptySpecification;
use AppBundle\Specification\CourseInfoEquipmentsEquipmentsAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationAdvicesAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationCtAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationMccAreEmptySpecification;
use AppBundle\Specification\CourseInfoEvaluationMethodsAreEmptySpecification;
use AppBundle\Specification\CourseInfoInfoAgendaAreEmptySpecification;
use AppBundle\Specification\CourseInfoInfoOrganizationAreEmptySpecification;
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
        return (
            $this->evaluationAdvicesAreEmpty($courseInfo) &&
            $this->evaluationMethodsAreEmpty($courseInfo) &&
            $this->evaluationMccAreEmpty($courseInfo)
        );
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

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function evaluationCtAreEmpty(CourseInfo $courseInfo){
        $courseInfoEvaluationCtAreEmptySpecification = new CourseInfoEvaluationCtAreEmptySpecification();
        return $courseInfoEvaluationCtAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function equipementsAreEmpty(CourseInfo $courseInfo){
        return (
            $this->equipementsEquipmentsAreEmpty($courseInfo) &&
            $this->equipementsEducationalResourcesAreEmpty($courseInfo) &&
            $this->equipementsBibliographicResourcesAreEmpty($courseInfo)
        );
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function equipementsEquipmentsAreEmpty(CourseInfo $courseInfo){
        $courseInfoEquipmentsEquipmentsAreEmptySpecification = new CourseInfoEquipmentsEquipmentsAreEmptySpecification();
        return $courseInfoEquipmentsEquipmentsAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function equipementsEducationalResourcesAreEmpty(CourseInfo $courseInfo){
        $courseInfoEquipmentsEducationalResourcesAreEmptySpecification = new CourseInfoEquipmentsEducationalResourcesAreEmptySpecification();
        return $courseInfoEquipmentsEducationalResourcesAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function equipementsBibliographicResourcesAreEmpty(CourseInfo $courseInfo){
        $courseInfoEquipmentsBibliographicResourcesAreEmptySpecification = new CourseInfoEquipmentsBibliographicResourcesAreEmptySpecification();
        return $courseInfoEquipmentsBibliographicResourcesAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function infoAreEmpty(CourseInfo $courseInfo){
        return (
            $this->infoAgendaAreEmpty($courseInfo) &&
            $this->infoOrganizationAreEmpty($courseInfo)
        );
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function infoAgendaAreEmpty(CourseInfo $courseInfo){
        $courseInfoInfoAgendaAreEmptySpecification = new CourseInfoInfoAgendaAreEmptySpecification();
        return $courseInfoInfoAgendaAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function infoOrganizationAreEmpty(CourseInfo $courseInfo){
        $courseInfoInfoOrganizationAreEmptySpecification = new CourseInfoInfoOrganizationAreEmptySpecification();
        return $courseInfoInfoOrganizationAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function closingInfoAreEmpty(CourseInfo $courseInfo){
        return (
            $this->closingRemarksAreEmpty($courseInfo) &&
            $this->closingVideoIsEmpty($courseInfo)
        );
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function closingRemarksAreEmpty(CourseInfo $courseInfo){
        $courseInfoClosingRemarksAreEmptySpecification = new CourseInfoClosingRemarksAreEmptySpecification();
        return $courseInfoClosingRemarksAreEmptySpecification->isSatisfiedBy($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function closingVideoIsEmpty(CourseInfo $courseInfo){
        $courseInfoClosingVideoIsEmptySpecification = new CourseInfoClosingVideoIsEmptySpecification();
        return $courseInfoClosingVideoIsEmptySpecification->isSatisfiedBy($courseInfo);
    }


}