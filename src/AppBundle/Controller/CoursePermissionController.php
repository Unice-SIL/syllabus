<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * CoursePermission controller.
 *
 */
class CoursePermissionController extends Controller
{
    /**
     * Lists all CoursePermission entities.
     *
     * @Route("/course/{id}/permissions", name="app_course_permission")
     * @Method("GET")
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        //todo: add addSelect to get coursePermission and user with courseInfo
        return $this->render('course_info/permission/index.html.twig', array(
            'courseInfo' => $courseInfo,
        ));
    }

}
