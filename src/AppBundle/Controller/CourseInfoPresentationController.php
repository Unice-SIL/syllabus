<?php

namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Presentation\GeneralType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoPresentationController extends AbstractController
{
    /**
     * @Route("/course/{id}/presentation", name="course_presentation")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        return $this->render('course_info/presentation/presentation.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/course/{id}/presentation/general", name="course_presentation_general")
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generalAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $form = $this->createForm(GeneralType::class, $courseInfo);
        $form->handleRequest($request);

        return $this->render('course_info/presentation/form/general.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
    }
}