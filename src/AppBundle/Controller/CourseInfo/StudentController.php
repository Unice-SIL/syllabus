<?php

namespace AppBundle\Controller\CourseInfo;

use AppBundle\Constant\Permission;
use AppBundle\Entity\CourseInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudentController
 * @package AppBundle\Controller
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
    public function studentView(CourseInfo $courseInfo)
    {
        if (!$courseInfo->getPublisher() && !$this->get('security.authorization_checker')->isGranted(Permission::WRITE, $courseInfo))
        {
            return $this->render('course_info/view/not_published.html.twig', array(
                'courseInfo' => $courseInfo,
            ));
        }
        return $this->render('course_info/view/not_published.html.twig', array(
            'courseInfo' => $courseInfo,
        ));
        return $this->render('course_info/view/view.html.twig', array(
            'courseInfo' => $courseInfo,
        ));
    }
}