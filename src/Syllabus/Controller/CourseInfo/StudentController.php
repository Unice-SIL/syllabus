<?php

namespace App\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package App\Syllabus\Controller
 */
#[Route(path: '/course-info/{id}/view', name: 'app.course_info.view.')]
class StudentController extends AbstractController
{

    
    #[Route(path: '/', name: 'student')]
    public function studentView(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/view/view.html.twig', array(
            'courseInfo' => $courseInfo,
        ));
    }
}