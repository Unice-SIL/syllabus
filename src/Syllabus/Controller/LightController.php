<?php


namespace App\Syllabus\Controller;


use App\Syllabus\Entity\CourseInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LightController
 * @package App\Syllabus\Controller
 * @Route("/course-info/{id}/view", name="app.course_info.view.")
 */
class LightController extends AbstractController
{

    /**
     * @Route("/light",name="light_version")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function lightVersionView(CourseInfo $courseInfo): Response
    {
        return $this->render('lightVersion/light_layout.html.twig', array(
            'courseInfo' => $courseInfo,
        ));
    }
}