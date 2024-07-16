<?php

namespace App\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Syllabus\Controller
 * @Route("/course-info/{id}/view", name="app.course_info.view.")
 */
class StudentController extends AbstractController
{

    /**
     * @Route("/",name="student")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function studentView(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/view/view.html.twig', array(
            'courseInfo' => $courseInfo,
        ));
    }
}