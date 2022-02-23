<?php

namespace App\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Form\CourseInfo\Activities\DuplicateCourseSectionType;
use App\Syllabus\Form\CourseInfo\Activities\SectionType;
use App\Syllabus\Manager\ActivityManager;
use App\Syllabus\Manager\ActivityTypeManager;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Manager\CourseSectionManager;
use Exception;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * Class ActivitiesController
 * @package App\Syllabus\Controller\CourseInfo
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
        $activities = $activityManager->findAllNotObsolete();
        $activityTypes = $activityTypeManager->findAllNotObsolete();


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
     * @param Environment $twig
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @param CourseSectionManager $courseSectionManager
     * @param TranslatorInterface $translator
     * @return Response
     * @throws Exception
     */
    public function addSectionAction(Environment $twig, CourseInfo $courseInfo, Request $request, CourseInfoManager $manager, CourseSectionManager $courseSectionManager, TranslatorInterface $translator)
    {
        $status = true;
        $message = null;
        $section = $courseSectionManager->new();

        $form = $this->createForm(SectionType::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid())
            {
                $section->setId(Uuid::uuid4())
                    ->setPosition(count($courseInfo->getCourseSections()))
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

        $render = $twig->render('course_info/activities/form/add_section.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView(),
            'sectionId' => $section->getId()
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
     * @param TranslatorInterface $translator
     * @return JsonResponse
     * @ParamConverter("courseSection", options={"mapping": {"sectionId": "id"}})
     */
    public function duplicateSectionAction(Environment $twig, CourseInfo $courseInfo, CourseSection $courseSection, Request $request, CourseInfoManager $manager, TranslatorInterface $translator)
    {
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

        $render = $twig->render('course_info/activities/form/duplicate_section.html.twig', [
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
     * @return JsonResponse
     * @throws Exception
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