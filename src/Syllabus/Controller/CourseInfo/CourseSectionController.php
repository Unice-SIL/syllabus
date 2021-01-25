<?php

namespace App\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\Activity;
use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Form\CourseInfo\Activities\CourseSectionActivityType;
use App\Syllabus\Form\CourseInfo\Activities\RemoveSectionType;
use App\Syllabus\Form\CourseInfo\Activities\SectionType;
use App\Syllabus\Manager\CourseSectionActivityManager;
use App\Syllabus\Manager\CourseSectionManager;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class CourseSectionController
 * @package App\Syllabus\Controller\CourseInfo
 * @Route("/course-info/section/{id}", name="app.course_info.section.")
 * @Security("is_granted('WRITE', section)")
 */
class CourseSectionController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
     *
     * @param CourseSection|null $section
     * @param Request $request
     * @param CourseSectionManager $courseSectionManager
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editSectionAction(?CourseSection $section, Request $request, CourseSectionManager $courseSectionManager, TranslatorInterface $translator)
    {
        if (!$section instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_section')
            ]);
        }

        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseSectionManager->update($section);
        }

        $render = $this->get('twig')->render('course_info/activities/form/edit_section.html.twig', [
            'form' => $form->createView(),
            'sectionId' => $section->getId()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     *
     * @param CourseSection $section
     * @param Request $request
     * @param CourseSectionManager $courseSectionManager
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function removeSectionAction(CourseSection $section, Request $request, CourseSectionManager $courseSectionManager, TranslatorInterface $translator)
    {
        if (!$section instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_section')
            ]);
        }

        $form = $this->createForm(RemoveSectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $courseSectionManager->delete($section);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/activities/form/remove_section.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/activity/{activityId}/activityType/{activityTypeId}/add", name="activity.add"))
     *
     * @param CourseSection $section
     * @param Activity $activity
     * @param ActivityType $activityType
     * @param Request $request
     * @param CourseSectionActivityManager $courseSectionActivityManager
     * @param CourseSectionManager $courseSectionManager
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @ParamConverter("activity", options={"mapping": {"activityId": "id"}})
     * @ParamConverter("activityType", options={"mapping": {"activityTypeId": "id"}})
     */
    public function addCourseSectionActivityAction(CourseSection $section, Activity $activity, ActivityType $activityType, Request $request,
                                                   CourseSectionActivityManager $courseSectionActivityManager, CourseSectionManager $courseSectionManager,
                                                   TranslatorInterface $translator)
    {

        if (!$section instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_section')
            ]);
        }

        if (!$activityType instanceof ActivityType)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_activity_type')
            ]);
        }

        if (!$activity instanceof Activity)
        {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_activity')
            ]);
        }

        $courseSectionActivity = $courseSectionActivityManager->new();
        $courseSectionActivity->setActivityType($activityType);

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
                $courseSectionActivity->setId(Uuid::uuid4())
                    ->setCourseSection($section)
                    ->setPosition(count($section->getCourseSectionActivities()))
                    ->setActivity($activity);
                $courseSectionActivityManager->create($courseSectionActivity);
                $courseSectionManager->update($section);
            }
            else
            {
                $status = false;
                $message = ['type' => 'none'];
            }
        }

        $render = $this->get('twig')->render('course_info/activities/form/add_activity.html.twig', [
            'courseSection' => $section,
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
     * @Route("/activities/sort", name="activities.sort"))
     *
     * @param CourseSection $section
     * @param Request $request
     * @param CourseSectionManager $courseSectionManager
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sortCourseSectionActivitiesAction(CourseSection $section,
                                                      Request $request,
                                                      CourseSectionManager $courseSectionManager,
                                                      TranslatorInterface $translator)
    {
        if (!$section instanceof CourseSection) {
            return $this->json([
                'status' => false,
                'render' => $translator->trans('app.controller.error.empty_section')
            ]);
        }

        $activities = $section->getCourseSectionActivities();
        $dataActivities = $request->request->get('data');

        if ($dataActivities)
        {
            foreach ($activities as $activity) {
                if (in_array($activity->getId(), $dataActivities)) {
                    $activity->setPosition(array_search($activity->getId(), $dataActivities));
                }
            }
            $courseSectionManager->update($section);
        }

        return $this->json([
            'status' => true,
            'content' => null
        ]);
    }
}