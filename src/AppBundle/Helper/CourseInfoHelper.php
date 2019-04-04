<?php

namespace AppBundle\Helper;

use AppBundle\Entity\CourseInfo;
use AppBundle\Specification\CanBePublishedCourseInfoSpecification;

/**
 * Class CourseInfoHelper
 * @package AppBundle\Helper
 */
class CourseInfoHelper
{
    /**
     * @var CanBePublishedCourseInfoSpecification
     */
    private $canBePublishedCourseInfoSpecification;

    /**
     * CourseInfoHelper constructor.
     */
    public function __construct()
    {
        $this->canBePublishedCourseInfoSpecification = new CanBePublishedCourseInfoSpecification();
    }

    /**
     * @param CourseInfo $courseInfo
     * @return bool
     */
    public function canBePublished(CourseInfo $courseInfo){
        return $this->canBePublishedCourseInfoSpecification->isSatisfiedBy($courseInfo);
    }
}