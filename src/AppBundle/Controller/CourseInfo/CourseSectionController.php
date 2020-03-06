<?php

namespace AppBundle\Controller\CourseInfo;

use AppBundle\Entity\Activity;
use AppBundle\Entity\ActivityType;
use AppBundle\Entity\CourseSection;
use AppBundle\Form\CourseInfo\Activities\CourseSectionActivityType;
use AppBundle\Form\CourseInfo\Activities\RemoveSectionType;
use AppBundle\Form\CourseInfo\Activities\SectionType;
use AppBundle\Manager\CourseSectionActivityManager;
use AppBundle\Manager\CourseSectionManager;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseSectionController
 * @package AppBundle\Controller\CourseInfo
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editSectionAction(?CourseSection $section, Request $request, CourseSectionManager $courseSectionManager)
    {
        if (!$section instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : La section n'existe pas"
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
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function removeSectionAction(CourseSection $section, Request $request, CourseSectionManager $courseSectionManager)
    {
        if (!$section instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : La section n'existe pas"
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
     * @param CourseSection $courseSection
     * @param Activity $activity
     * @param ActivityType $activityType
     * @param Request $request
     * @param CourseSectionActivityManager $courseSectionActivityManager
     * @param CourseSectionManager $courseSectionManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @ParamConverter("activity", options={"mapping": {"activityId": "id"}})
     * @ParamConverter("activityType", options={"mapping": {"activityTypeId": "id"}})
     */
    public function addCourseSectionActivityAction(CourseSection $courseSection, Activity $activity, ActivityType $activityType, Request $request,
                                                   CourseSectionActivityManager $courseSectionActivityManager, CourseSectionManager $courseSectionManager)
    {
        $status = true;
        $message = null;
        $courseSectionActivity = $courseSectionActivityManager->new();

        if (!$courseSection instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : La section n'existe pas"
            ]);
        }

        if (!$activityType instanceof ActivityType)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le type d'activité n'existe pas"
            ]);
        }

        if (!$activity instanceof Activity)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : L'activité n'existe pas"
            ]);
        }

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
        $form = $this->createForm(CourseSectionActivityType::class, $courseSectionActivity, [
            'activity' => $activity
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $courseSectionActivity->setId(Uuid::uuid4())
                    ->setCourseSection($courseSection)
                    ->setActivity($activity);
                $courseSectionActivityManager->create($courseSectionActivity);
                foreach ($courseSection->getCourseSectionActivities() as $courseSectionActivity) {
                    $courseSectionActivity->setPosition($courseSectionActivity->getPosition() + 1);
                }
                $courseSectionManager->update($courseSection);
            }
            else
            {
                $status = false;
                $message = ['type' => 'none'];
            }
        }

        $render = $this->get('twig')->render('course_info/activities/form/add_activity.html.twig', [
            'courseSection' => $courseSection,
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
     * @param CourseSection $courseSection
     * @param Request $request
     * @param CourseSectionManager $courseSectionManager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sortCourseSectionActivitiesAction(CourseSection $courseSection, Request $request, CourseSectionManager $courseSectionManager)
    {
        if (!$courseSection instanceof CourseSection) {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : La section n'existe pas"
            ]);
        }

        $activities = $courseSection->getCourseSectionActivities();
        $dataActivities = $request->request->get('data');

        if ($dataActivities)
        {
            foreach ($activities as $activity) {
                if (in_array($activity->getId(), $dataActivities)) {
                    $activity->setPosition(array_search($activity->getId(), $dataActivities));
                }
            }
            $courseSectionManager->update($courseSection);
        }

        return $this->json([
            'status' => true,
            'content' => null
        ]);
    }
}