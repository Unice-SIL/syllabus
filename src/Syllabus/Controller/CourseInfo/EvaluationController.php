<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\Evaluation\SpecificationsType;
use App\Syllabus\Manager\CourseInfoManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class EvaluationController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/evaluation", name="app.course_info.evaluation.")
 * @Security("is_granted('WRITE', courseInfo)")
 *
 */
class EvaluationController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/evaluation/evaluation.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/specifications", name="specifications"))
     *
     * @param CourseInfo $courseInfo
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function generalViewAction(CourseInfo $courseInfo, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
            ]);
        }

        $render = $this->get('twig')->render('course_info/evaluation/view/specifications.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/specifications/edit", name="specifications.edit"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function specificationsFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, TranslatorInterface $translator)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_course')
            ]);
        }

        $form = $this->createForm(SpecificationsType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
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