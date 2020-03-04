<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{

    /**
     * @Route("course/{id}/student_view",name="app_student_view", methods={"GET"})
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function studentView(CourseInfo $courseInfo)
    {
        return $this->render('student_view.html.twig', array(
            'courseInfo' => $courseInfo,
        ));
    }
}