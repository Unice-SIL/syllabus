<?php

namespace AppBundle\Controller\CourseInfo;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use AppBundle\Form\CourseInfo\Activities\DuplicateCourseSectionType;
use AppBundle\Form\CourseInfo\Activities\SectionType;
use AppBundle\Manager\ActivityManager;
use AppBundle\Manager\ActivityTypeManager;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseSectionManager;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActivitiesController
 * @package AppBundle\Controller\CourseInfo
 * @Route("/course-info/{id}/activities", name="app.course_info.activities.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class ActivitiesController extends AbstractController
{
    /**
     * @Route("/{sectionId}", name="index", defaults={"sectionId"=null})
     *
     * @param CourseInfo $courseInfo
     * @param CourseSection|null $activeSection
     * @param ActivityManager $activityManager
     * @param ActivityTypeManager $activityTypeManager
     * @return Response
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
     * @Route("/section/add", name="section.add"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param CourseSectionManager $courseSectionManager
     * @return Response
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
     * @Route("/section/{sectionId}/duplicate", name="section.duplicate"))
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

    /**
     * @Route("/sections/sort", name="sections.sort"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
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
}