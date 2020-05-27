<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Closing_remarks\Closing_remarksType;
use AppBundle\Manager\CourseInfoManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class ClosingRemarkController
 * @package AppBundle\Controller\CourseInfo
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
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/closing_remarks/closing_remarks.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/closing-remarks", name="closing_remarks"))
     *
     * @param CourseInfo|null $courseInfo
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function closingRemarksViewAction(CourseInfo $courseInfo, Request $request, TranslatorInterface $translator)
    {
        if(!$courseInfo instanceof CourseInfo){
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
            ]);
        }

        $form = $this->createForm(Closing_remarksType::class, $courseInfo);
        $form->handleRequest($request);

        $render = $this->get('twig')->render('course_info/closing_remarks/view/closing_remarks.html.twig', [
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
     * @param CourseInfo|null $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function closingRemarksFormAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, TranslatorInterface $translator)
    {
        if(!$courseInfo instanceof CourseInfo){
            return $this->json([
                'status' => false,
                'content' => $translator->trans('app.controller.error.empty_course')
            ]);
        }

        $form = $this->createForm(Closing_remarksType::class, $courseInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($courseInfo);
            $render = $this->get('twig')->render('course_info/closing_remarks/view/closing_remarks.html.twig', [
                'courseInfo' => $courseInfo
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }

        $render = $this->get('twig')->render('course_info/closing_remarks/form/closing_remarks.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}