<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Info\InfoType;
use AppBundle\Manager\CourseInfoManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoInfoController
 * @package AppBundle\Controller
 *
 * @Route("/course/{id}/info_course", name="course_info_")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class CourseInfoInfoController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/info/info.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/info/view", name="convenient_view")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @return Response
     */
    public function infoCourseViewAction(CourseInfo $courseInfo, Request $request)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $form = $this->createForm(InfoType::class, $courseInfo);
        $form->handleRequest($request);

        $render = $this->get('twig')->render('course_info/info/view/info.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/info/form", name="convenient_form")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return Response
     * @throws \Exception
     */
    public function closingRemarksFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        $form = $this->createForm(InfoType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $this->get('twig')->render('course_info/info/view/info.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $this->get('twig')->render('course_info/info/form/info.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}