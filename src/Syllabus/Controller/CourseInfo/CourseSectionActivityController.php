<?php

namespace App\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\CourseSectionActivity;
use App\Syllabus\Form\CourseInfo\Activities\CourseSectionActivityType;
use App\Syllabus\Form\CourseInfo\Activities\RemoveCourseSectionActivityType;
use App\Syllabus\Manager\CourseSectionActivityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CourseSectionActivityController
 * @package App\Syllabus\Controller\CourseInfo
 * @Route("/course-info/section-activity/{id}", name="app.course_info.section_activity.")
 * @Security("is_granted('WRITE', courseSectionActivity)")

 */
class CourseSectionActivityController extends AbstractController
{
    /**
     * @Route("/activity/{activityId}/edit", name="edit"))
     *
     * @param Environment $twig
     * @param CourseSectionActivity $courseSectionActivity
     * @param Activity $activity
     * @param Request $request
     * @param CourseSectionActivityManager $manager
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @ParamConverter("activity", options={"mapping": {"activityId": "id"}})
     */
    public function editCourseSectionActivityAction(Environment $twig,  CourseSectionActivity $courseSectionActivity, Activity $activity,
                                                    Request $request, CourseSectionActivityManager $manager): JsonResponse
    {
        $status = true;
        $message = null;
        $form = $this->createForm(CourseSectionActivityType::class, $courseSectionActivity, [
            'activity' => $activity
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $manager->update($courseSectionActivity);
            }
            else
            {
                $status = false;
                $message = ['type' => 'none'];
            }
        }

        $render = $twig->render('course_info/activities/form/edit_activity.html.twig', [
            'courseSectionActivity' => $courseSectionActivity,
            'activity' => $activity,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => $status,
            'content' => $render,
            'message' => $message
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     *
     * @param CourseSectionActivity $courseSectionActivity
     * @param Request $request
     * @param CourseSectionActivityManager $manager
     * @param Environment $twig
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @ParamConverter("courseSection", options={"mapping": {"sectionId": "id"}})
     */
    public function removeCourseSectionActivityAction(
        CourseSectionActivity $courseSectionActivity,Request $request,
        CourseSectionActivityManager $manager,
        Environment $twig
    ): Response
    {

        $status = true;
        $message = null;
        $form = $this->createForm(RemoveCourseSectionActivityType::class, $courseSectionActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $manager->delete($courseSectionActivity);
                return $this->json([
                    'status' => $status,
                    'content' => null
                ]);
            }
            else
            {
                $status = false;
                $message = ['type' => 'none'];
            }
        }

        $render = $twig->render('course_info/activities/form/remove_activity.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => $status,
            'content' => $render,
            'message' => $message
        ]);
    }
}