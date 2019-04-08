<?php

namespace AppBundle\Helper;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\User;
use AppBundle\Specification\CanBePublishedCourseInfoSpecification;

/**
 * Class CoursePermissionHelper
 * @package AppBundle\Helper
 */
class CoursePermissionHelper
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
     * @param User $user
     * @param $permission
     * @return bool
     */
    public function hasPermission(CourseInfo $courseInfo, User $user, $permission){
        foreach($courseInfo->getCoursePermissions() as $coursePermission){
            if($coursePermission->getUser() == $user && $coursePermission->getPermission() === $permission){
                return true;
            }
        }
        return false;
    }
}