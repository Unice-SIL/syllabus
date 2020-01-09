<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Closing_remarks\Closing_remarksType;
use AppBundle\Manager\CourseInfoManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoClosingRemarksController extends Controller
{
    /**
     * @Route("/course/{id}/closing_remarks", name="course_closing_remarks")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        return $this->render('course_info/closing_remarks/closing_remarks.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/course/{id}/closing_remarks/end_word/{action}", name="course_closing_remarks_message", defaults={"action"=null}))
     *
     * @param $id
     * @param $action
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function closingRemarksAction($id, $action, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        $form = $this->createForm(Closing_remarksType::class, $courseInfo);
        $form->handleRequest($request);

        if ($action === "cancel")
        {
            return $this->render('course_info/closing_remarks/view/closing_remarks.html.twig', [
                'courseInfo' => $courseInfo,
            ]);

        }

        if ($form->isSubmitted() && $form->isValid()) {
            if ($action === "submit")
            {
                $manager->update($courseInfo);
            }
            return $this->render('course_info/closing_remarks/view/closing_remarks.html.twig', [
                'courseInfo' => $courseInfo,
            ]);
        }
        return $this->render('course_info/closing_remarks/form/closing_remarks.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
    }
}