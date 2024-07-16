<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\Info\InfoType;
use App\Syllabus\Manager\CourseInfoManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class InfoController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/info", name="app.course_info.info.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class InfoController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/info/info.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/info", name="info")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param Environment $twig
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function infoCourseViewAction(CourseInfo $courseInfo, Request $request, Environment $twig): Response
    {
        $form = $this->createForm(InfoType::class, $courseInfo);
        $form->handleRequest($request);

        $render = $twig->render('course_info/info/view/info.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/info/edit", name="info.edit")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param Environment $twig
     * @param CourseInfoManager $manager
     * @return Response
     * @throws \Exception
     */
    public function closingRemarksFormAction(
        CourseInfo $courseInfo,
        Request $request,
        CourseInfoManager $manager,
        Environment $twig
    ): Response
    {
        $form = $this->createForm(InfoType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $twig->render('course_info/info/view/info.html.twig', [
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