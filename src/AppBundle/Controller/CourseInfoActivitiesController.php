<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Activity;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseSectionActivity;
use AppBundle\Form\CourseInfo\Activities\CourseSectionActivityType;
use AppBundle\Form\CourseInfo\Activities\SectionType;
use AppBundle\Form\CourseInfo\Activities\RemoveSectionType;
use AppBundle\Manager\ActivityManager;
use AppBundle\Manager\ActivityTypeManager;
use AppBundle\Manager\CourseInfoManager;
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

    /**
     * @Route("/course/{id}/activities/section/edit/{sectionId}", name="course_activities_edit_section"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseSection|null $section
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @ParamConverter("section", options={"mapping": {"sectionId": "id"}})
     */
    public function editSectionAction(CourseInfo $courseInfo, ?CourseSection $section, Request $request, CourseInfoManager $manager)
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
                $manager->update($courseInfo);
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
     * @Route("/course/{id}/activities/section/add", name="course_activities_add_section"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addSectionAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
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
        $section = new CourseSection();

        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid())
            {
                $section->setId(Uuid::uuid4())
                    ->setCourseInfo($courseInfo);
                $courseInfo->addCourseSection($section);
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
     * @Route("/course/{id}/activities/sections/remove/{sectionId}", name="course_activities_remove_section"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseSection $section
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     * @ParamConverter("section", options={"mapping": {"sectionId": "id"}})
     */
    public function removeTeacherAction(CourseInfo $courseInfo, CourseSection $section, Request $request, CourseInfoManager $manager)
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
            $courseInfo->removeCourseSection($section);
            $manager->update($courseInfo);
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
     * @Route("/course/activities/section/{sectionId}/activity/{activityId}/add", name="course_activities_add_activity"))
     *
     * @param CourseSection $courseSection
     * @param Activity $activity
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     * @ParamConverter("courseSection", options={"mapping": {"sectionId": "id"}})
     * @ParamConverter("activity", options={"mapping": {"activityId": "id"}})
     */
    public function addActivityAction(CourseSection $courseSection, Activity $activity, Request $request)
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

        if (!$activity instanceof Activity)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : L'activité n'existe pas"
            ]);
        }

        $courseSectionActivity = new CourseSectionActivity();
        if (!$activity->getActivityTypes()->isEmpty())
        {
            $courseSectionActivity->setActivityType($activity->getActivityTypes()->current());
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
}