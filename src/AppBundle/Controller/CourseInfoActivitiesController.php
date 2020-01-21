<?php

namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoActivitiesController extends AbstractController
{
    /**
     * @Route("/course/{id}/activities", name="course_activities")
     *
     * @param CourseInfo $courseInfo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/activities/activities.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }
}