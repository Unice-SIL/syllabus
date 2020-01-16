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
     * @Route("/course/{id}/evaluation/specifications/view", name="course_evaluation_specifications_view"))
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function generalViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $render = $this->get('twig')->render('course_info/evaluation/view/specifications.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/evaluation/specifications/form", name="course_evaluation_specifications_form"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function specificationsFormAction($id, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);
        dump($courseInfo);

        $form = $this->createForm(SpecificationsType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            dump($courseInfo);
            $render = $this->get('twig')->render('course_info/evaluation/view/specifications.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }
        $render = $this->get('twig')->render('course_info/evaluation/form/specifications.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}