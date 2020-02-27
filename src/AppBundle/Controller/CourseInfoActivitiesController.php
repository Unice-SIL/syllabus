<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Activity;
use AppBundle\Entity\ActivityType;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseSectionActivity;
use AppBundle\Form\CourseInfo\Activities\CourseSectionActivityType;
use AppBundle\Form\CourseInfo\Activities\DuplicateCourseSectionType;
use AppBundle\Form\CourseInfo\Activities\RemoveCourseSectionActivityType;
use AppBundle\Form\CourseInfo\Activities\RemoveSectionType;
use AppBundle\Form\CourseInfo\Activities\SectionType;
use AppBundle\Manager\ActivityManager;
use AppBundle\Manager\ActivityTypeManager;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseSectionActivityManager;
use AppBundle\Manager\CourseSectionManager;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoActivitiesController extends AbstractController
{
    /**
     * @Route("/course/{id}/activities/{sectionId}", name="course_activities", defaults={"sectionId"=null})
     *
     * @param CourseInfo $courseInfo
     * @param CourseSection|null $activeSection
     * @param ActivityManager $activityManager
     * @param ActivityTypeManager $activityTypeManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("activeSection", options={"mapping": {"sectionId": "id"}})
     */
    public function indexAction(CourseInfo $courseInfo, ?CourseSection $activeSection, ActivityManager $activityManager, ActivityTypeManager $activityTypeManager)
    {
        if (!$activeSection)
        {
            if (!$courseInfo->getCourseSections()->isEmpty())
            {
                $activeSection = $courseInfo->getCourseSections()->current();
            }
        }
        $activities = $activityManager->findAll();
        $activityTypes = $activityTypeManager->findAll();

        return $this->render('course_info/activities/activities.html.twig', [
            'courseInfo' => $courseInfo,
            'activeSection' => $activeSection,
            'activities' => $activities,
            'activityTypes' => $activityTypes
        ]);
    }

    /*
     * Sections
     */

    /**
     * @Route("/course/{id}/activities/section/add", name="course_activities_add_section"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param CourseSectionManager $courseSectionManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addSectionAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, CourseSectionManager $courseSectionManager)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

        $status = true;
        $message = null;
        $section = $courseSectionManager->new();

        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid())
            {
                $section->setId(Uuid::uuid4())
                    ->setCourseInfo($courseInfo);

                $courseInfo->addCourseSection($section);
                foreach ($courseInfo->getCourseSections() as $section) {
                    $section->setPosition($section->getPosition() + 1);
                }
                $manager->update($courseInfo);
            }
            else
            {
                $status = false;
                $message = ['type' => 'none'];
            }
        }

        $render = $this->get('twig')->render('course_info/activities/form/add_section.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => $status,
            'content' => $render,
            'message' => $message
        ]);
    }

    /**
     * @Route("/course/{id}/activities/section/edit/{sectionId}", name="course_activities_edit_section"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseSection|null $section
     * @param Request $request
     * @param CourseSectionManager $courseSectionManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("section", options={"mapping": {"sectionId": "id"}})
     */
    public function editSectionAction(CourseInfo $courseInfo, ?CourseSection $section, Request $request, CourseSectionManager $courseSectionManager)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

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
            'courseInfo' => $courseInfo,
            'form' => $form->createView(),
            'sectionId' => $section->getId()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/activities/sections/remove/{sectionId}", name="course_activities_remove_section"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseSection $section
     * @param Request $request
     * @param CourseSectionManager $courseSectionManager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @ParamConverter("section", options={"mapping": {"sectionId": "id"}})
     */
    public function removeSectionAction(CourseInfo $courseInfo, CourseSection $section, Request $request, CourseSectionManager $courseSectionManager)
    {
        if (!$courseInfo instanceof CourseInfo)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : Le cours n'existe pas"
            ]);
        }

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
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/activities/courseInfo/{courseInfoId}/courseSections/sort", name="course_activities_sort_sections"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @ParamConverter("courseInfo", options={"mapping": {"courseInfoId": "id"}})
     */
    public function sortSectionsAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        $sections = $courseInfo->getCourseSections();
        $dataSections = $request->request->get('data');

        if ($dataSections)
        {
            foreach ($sections as $section) {
                if (in_array($section->getId(), $dataSections)) {
                    $section->setPosition(array_search($section->getId(), $dataSections));
                }
            }
            $manager->update($courseInfo);
        }

        return $this->json([
            'status' => true,
            'content' => null
        ]);
    }

    /**
     * @Route("/course/{id}/activities/section/{sectionId}/duplicate", name="course_activities_duplicate_section"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseSection $courseSection
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @ParamConverter("courseSection", options={"mapping": {"sectionId": "id"}})
     * @throws \Exception
     */
    public function duplicateSectionAction(CourseInfo $courseInfo, CourseSection $courseSection, Request $request, CourseInfoManager $manager)
    {
        if (!$courseSection instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : La section n'existe pas"
            ]);
        }

        $form = $this->createForm(DuplicateCourseSectionType::class, $courseSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $newSection = clone $courseSection;

            foreach ($courseInfo->getCourseSections() as $section) {
                if ($courseSection->getPosition() < $section->getPosition())
                $section->setPosition($section->getPosition() + 1);
            }
            $newSection->setPosition($courseSection->getPosition() + 1);
            $courseInfo->addCourseSection($newSection);
            
            $manager->update($courseInfo);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/activities/form/duplicate_section.html.twig', [
            'courseInfo' => $courseInfo,
            'courseSection' => $courseSection,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /*
     * CourseSectionActivity
     */

    /**
     * @Route("/course/activities/section/{sectionId}/activity/{activityId}/activityType/{activityTypeId}/add", name="course_activities_add_activity"))
     *
     * @param CourseSection $courseSection
     * @param Activity $activity
     * @param ActivityType $activityType
     * @param Request $request
     * @param CourseSectionActivityManager $courseSectionActivityManager
     * @param CourseSectionManager $courseSectionManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @ParamConverter("courseSection", options={"mapping": {"sectionId": "id"}})
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
     * @Route("/course/activities/courseSectionActivity/{courseSectionActivityId}/activity/{activityId}/edit", name="course_activities_edit_activity"))
     *
     * @param CourseSectionActivity $courseSectionActivity
     * @param Activity $activity
     * @param Request $request
     * @param CourseSectionActivityManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @ParamConverter("courseSectionActivity", options={"mapping": {"courseSectionActivityId": "id"}})
     * @ParamConverter("activity", options={"mapping": {"activityId": "id"}})
     */
    public function editCourseSectionActivityAction(CourseSectionActivity $courseSectionActivity, Activity $activity, Request $request, CourseSectionActivityManager $manager)
    {
        $status = true;
        $message = null;

        if (!$courseSectionActivity instanceof CourseSectionActivity)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : La section n'existe pas"
            ]);
        }

        if (!$activity instanceof Activity)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : L'activité n'existe pas"
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
     * @Route("/course/activities/section/{sectionId}/activity/{courseSectionActivityId}/remove", name="course_activities_remove_activity"))
     *
     * @param CourseSection $courseSection
     * @param CourseSectionActivity $courseSectionActivity
     * @param Request $request
     * @param CourseSectionActivityManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("courseSection", options={"mapping": {"sectionId": "id"}})
     * @ParamConverter("courseSectionActivity", options={"mapping": {"courseSectionActivityId": "id"}})
     */
    public function removeCourseSectionActivityAction(CourseSection $courseSection, CourseSectionActivity $courseSectionActivity, Request $request, CourseSectionActivityManager $manager)
    {
        $status = true;
        $message = null;

        if (!$courseSection instanceof CourseSection)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : La section n'existe pas"
            ]);
        }

        if (!$courseSectionActivity instanceof CourseSectionActivity)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : L'activité n'existe pas"
            ]);
        }

        $form = $this->createForm(RemoveCourseSectionActivityType::class, $courseSectionActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->isValid())
            {
                $manager->delete($courseSectionActivity);
                return $this->json([
                    'status' => true,
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
            'courseSection' => $courseSection,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => $status,
            'content' => $render,
            'message' => $message
        ]);
    }

    /**
     * @Route("/course/activities/section/{courseSectionId}/courseSectionActivities/sort", name="course_activities_sort_activities"))
     *
     * @param CourseSection $courseSection
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @ParamConverter("courseSection", options={"mapping": {"courseSectionId": "id"}})
     */
    public function sortCourseSectionActivitiesAction(CourseSection $courseSection, Request $request)
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

            $this->getDoctrine()->getManager()->persist($courseSection);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->json([
            'status' => true,
            'content' => null
        ]);
    }
}