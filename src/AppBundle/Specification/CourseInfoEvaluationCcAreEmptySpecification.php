<?php

namespace AppBundle\Specification;

use AppBundle\Constant\ActivityType;
use AppBundle\Entity\CourseInfo;
use Tanigami\Specification\Specification;

/**
 * Class CourseInfoEvaluationCcAreEmptySpecification
 * @package AppBundle\Specification
 */
class CourseInfoEvaluationCcAreEmptySpecification extends Specification
{

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function isSatisfiedBy($courseInfo): bool
    {
        $countCcEvaluation = 0;
        foreach ($courseInfo->getCourseSections() as $section){
            foreach ($section->getCourseSectionActivities() as $activity){
                if($activity->getActivity()->getType() == ActivityType::EVALUATION){
                    $countCcEvaluation++;
                }
            }
        }
        if($countCcEvaluation == 0){
            return true;
        }
        return false;
    }
}