<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoObjectivesCourseController extends Controller
{
    /**
     * @Route("/course/{id}/objectives_course", name="course_info_objectives")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        return $this->render('course_info/objectives_course/objectives_course.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }
}