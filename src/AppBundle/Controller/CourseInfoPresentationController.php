<?php

namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Presentation\GeneralType;
use AppBundle\Manager\CourseInfoManager;
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
     * @Route("/course/{id}/presentation/general/{action}", name="course_presentation_general", defaults={"action"=null}))
     *
     * @param $id
     * @param $action
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function generalAction($id, $action, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $form = $this->createForm(GeneralType::class, $courseInfo);
        $form->handleRequest($request);

        dump(1, $action);
        if ($form->isSubmitted() && $form->isValid()) {
            dump(2);
            if ($action === "submit")
            {
                $manager->update($courseInfo);
            }
            return $this->render('course_info/presentation/view/general.html.twig', [
                'courseInfo' => $courseInfo,
            ]);
        }

        if ($action === "cancel")
        {
            return $this->render('course_info/presentation/view/general.html.twig', [
                'courseInfo' => $courseInfo,
            ]);

        }

        return $this->render('course_info/presentation/form/general.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);

    }
}