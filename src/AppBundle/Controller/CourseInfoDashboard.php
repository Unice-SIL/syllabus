<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoDashboard
 * @package AppBundle\Controller
 *
 * @Route("/course/{id}/dashboard", name="course_dashboard_")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class CourseInfoDashboard extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/dashboard/dashboard.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/view", name="view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function dashboardViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $render = $this->get('twig')->render('course_info/dashboard/view/dashboard.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}