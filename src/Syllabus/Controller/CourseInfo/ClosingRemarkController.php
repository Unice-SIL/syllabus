<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\Closing_remarks\Closing_remarksType;
use App\Syllabus\Manager\CourseInfoManager;
use Exception;
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
 * Class ClosingRemarkController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/closing-remarks", name="app.course_info.closing_remarks.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class ClosingRemarkController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/closing_remarks/closing_remarks.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/closing-remarks", name="closing_remarks"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param Environment $twig
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function closingRemarksViewAction(CourseInfo $courseInfo, Request $request, Environment $twig): Response
    {
        $form = $this->createForm(Closing_remarksType::class, $courseInfo);
        $form->handleRequest($request);

        $render = $twig->render('course_info/closing_remarks/view/closing_remarks.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/edit", name="closing_remarks.edit"))
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
    public function closingRemarksFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, Environment $twig): Response
    {
        $form = $this->createForm(Closing_remarksType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $twig->render('course_info/closing_remarks/view/closing_remarks.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $twig->render('course_info/closing_remarks/form/closing_remarks.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}