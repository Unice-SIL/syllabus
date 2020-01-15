<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Evaluation\SpecificationsType;
use AppBundle\Manager\CourseInfoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoEvaluationController
 * @package AppBundle\Controller
 */
class CourseInfoEvaluationController extends AbstractController
{
    /**
     * @Route("/course/{id}/evaluation", name="course_evaluation")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        return $this->render('course_info/evaluation/evaluation.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/course/{id}/evaluation/specifications/{action}", name="course_evaluation_specifications", defaults={"action"=null}))
     *
     * @param $id
     * @param $action
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function synopsisAction($id, $action, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $form = $this->createForm(SpecificationsType::class, $courseInfo);
        $form->handleRequest($request);

        if ($action === "cancel")
        {
            return $this->render('course_info/evaluation/view/specifications.html.twig', [
                'courseInfo' => $courseInfo,
            ]);

        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($action === "submit")
            {
                $manager->update($courseInfo);
            }
            return $this->render('course_info/evaluation/view/specifications.html.twig', [
                'courseInfo' => $courseInfo,
            ]);
        }

        return $this->render('course_info/evaluation/form/specifications.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
    }
}