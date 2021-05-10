<?php

namespace App\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityType;
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
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * @param CourseSectionActivity $courseSectionActivity
     * @param Activity $activity
     * @param Request $request
     * @param CourseSectionActivityManager $manager
     * @param TranslatorInterface $translator
     * @return JsonResponse
     * @ParamConverter("activity", options={"mapping": {"activityId": "id"}})
     */
    public function editCourseSectionActivityAction(CourseSectionActivity $courseSectionActivity, Activity $activity,
                                                    Request $request, CourseSectionActivityManager $manager, TranslatorInterface $translator)
    {

        if (!$courseSectionActivity instanceof CourseSectionActivity)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_section')
            ]);
        }

        if (!$activity instanceof Activity)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_activity')
            ]);
        }

        $typeId = $request->query->get('activity_type');
        if ($typeId)
        {
            $activityTypes = array_filter($activity->getActivityTypes()->toArray(), function (ActivityType $type) use ($typeId) {
                return $type->getId() === $typeId;
            });
            if (count($activityTypes) > 0)
            {
                $courseSectionActivity->setActivityType(current($activityTypes));
            }
        }

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

        $render = $this->get('twig')->render('course_info/activities/form/edit_activity.html.twig', [
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
     * @param TranslatorInterface $translator
     * @return Response
     * @ParamConverter("courseSection", options={"mapping": {"sectionId": "id"}})
     */
    public function removeCourseSectionActivityAction(CourseSectionActivity $courseSectionActivity,Request $request,
                                                      CourseSectionActivityManager $manager, TranslatorInterface $translator)
    {

        if (!$courseSectionActivity instanceof CourseSectionActivity)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_activity')
            ]);
        }

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

        $render = $this->get('twig')->render('course_info/activities/form/remove_activity.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => $status,
            'content' => $render,
            'message' => $message
        ]);
    }
}