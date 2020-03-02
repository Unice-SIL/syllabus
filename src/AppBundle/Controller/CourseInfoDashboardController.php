<?php


namespace AppBundle\Controller;


use AppBundle\Entity\AskAdvice;
use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\dashboard\AskAdviceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CourseInfoDashboard
 * @package AppBundle\Controller
 *
 * @Route("/course/{id}/dashboard", name="course_dashboard_")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class CourseInfoDashboardController extends AbstractController
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
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function dashboardViewAction(CourseInfo $courseInfo, ValidatorInterface $validator)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $validationsGroups = ['presentation', 'contentActivities', 'objectives', 'evaluation', 'equipment', 'info', 'closingRemark'];
        $violations = [];
        foreach ($validationsGroups as $validationsGroup) {
            $violations[$validationsGroup] = $validator->validate($courseInfo, null, $validationsGroup);
        }

        $render = $this->get('twig')->render('course_info/dashboard/view/dashboard.html.twig', [
            'courseInfo' => $courseInfo,
            'violations' => $violations
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/askAdvice", name="askAdvice"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @return JsonResponse
     */
    public function AskAdvice(CourseInfo $courseInfo, Request $request)
    {
        $askAdvice = new AskAdvice();
        $askAdvice->setUser($this->getUser())->setCourseInfo($courseInfo);
        $form = $this->createForm(AskAdviceType::class, $askAdvice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($askAdvice);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/dashboard/form/ask_advice.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}