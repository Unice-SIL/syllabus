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
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
    public function indexAction(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/evaluation/evaluation.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/specifications", name="specifications"))
     *
     * @param CourseInfo $courseInfo
     * @param Environment $twig
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generalViewAction(CourseInfo $courseInfo, Environment $twig): Response
    {
        $render = $twig->render('course_info/evaluation/view/specifications.html.twig', [
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
     * @param Environment $twig
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function specificationsFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, Environment $twig): Response
    {

        $form = $this->createForm(SpecificationsType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $twig->render('course_info/evaluation/view/specifications.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $twig->render('course_info/evaluation/form/specifications.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}