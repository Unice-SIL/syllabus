<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseTutoringResourcesType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseTutoringResourcesType;
use AppBundle\Manager\CourseInfoManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoObjectivesCourseController extends Controller
{
    /**
     * @Route("/course/{id}/objectives_course", name="course_info_objectives")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        return $this->render('course_info/objectives_course/objectives_course.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/achievement", name="objective_course_achievement"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function addAchievementAction($id, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);
        if(!$courseInfo instanceof CourseInfo){
            return $this->json([
                'status' => false,
                'content' => "Le cours {$id} n'existe pas."
            ]);
        }

        $courseAchievement = new CourseAchievement();
        $form = $this->createForm(CourseAchievementType::class, $courseAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseAchievement = $form->getData();
            $courseInfo->addCourseAchievement($courseAchievement);
            $manager->update($courseInfo);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/achievement/delete/{achievementId}", name="objective_course_remove_achievement"))
     *
     * @param $id
     * @param $achievementId
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteAchievementAction($id, $achievementId, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);
        /** @var CourseAchievement $achievement */
        $achievement = $em->getRepository(CourseAchievement::class)->find($achievementId);
        if (!$achievement instanceof CourseAchievement)
        {
            return $this->json([
                'status' => false,
                'content' => "La compétence {$achievementId} n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCourseAchievementType::class, $achievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var CourseAchievement $achievement */
            $achievement = $form->getData();
            $courseInfo->removeCourseAchievement($achievement);
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/prerequisite", name="objective_course_prerequisite"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function prerequisiteAction($id, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);
        if(!$courseInfo instanceof CourseInfo){
            return $this->json([
                'status' => false,
                'content' => "Le cours {$id} n'existe pas."
            ]);
        }

        $prerequisite = new CoursePrerequisite();
        $form = $this->createForm(CoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prerequisite = $form->getData();
            $courseInfo->addCoursePrerequisite($prerequisite);
            $manager->update($courseInfo);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/prerequisite.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/prerequisite/delete/{prerequisiteId}", name="objective_course_remove_prerequisite"))
     *
     * @param $id
     * @param $prerequisiteId
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     */
    public function deletePrerequisitesAction($id, $prerequisiteId, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);

        /** @var CoursePrerequisite $prerequisite */
        $prerequisite = $em->getRepository(CoursePrerequisite::class)->find($prerequisiteId);

        if (!$prerequisite instanceof CoursePrerequisite)
        {
            return $this->json([
                'status' => false,
                'content' => "Le prérequis {$prerequisiteId} n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var CoursePrerequisite $prerequisite */
            $prerequisite = $form->getData();
            $courseInfo->removeCoursePrerequisite($prerequisite);
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_prerequisite.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/tutoring_resources", name="objective_course_tutoring_resources"))
     *
     * @param $id
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function tutoringResourceAction($id, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);
        if(!$courseInfo instanceof CourseInfo){
            return $this->json([
                'status' => false,
                'content' => "Le cours {$id} n'existe pas."
            ]);
        }

        $tutoringResources = new CourseTutoringResource();
        $form = $this->createForm(CourseTutoringResourcesType::class, $tutoringResources);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tutoringResources = $form->getData();
            $courseInfo->addCourseTutoringResource($tutoringResources);
            $manager->update($courseInfo);

            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/tutoring_resources/delete/{tutoringResourcesId}", name="objective_course_remove_tutoring_resources"))
     *
     * @param $id
     * @param $tutoringResourcesId
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteTutoringResourcesAction($id, $tutoringResourcesId, Request $request, CourseInfoManager $manager)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $em->getRepository(CourseInfo::class)->find($id);
        /** @var CourseTutoringResource $tutoringResources */
        $tutoringResources = $em->getRepository(CourseTutoringResource::class)->find($tutoringResourcesId);
        if (!$tutoringResources instanceof CourseTutoringResource)
        {
            return $this->json([
                'status' => false,
                'content' => "La remédiation {$tutoringResourcesId} n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCourseTutoringResourcesType::class, $tutoringResources);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var CourseTutoringResource $tutoringResources */
            $tutoringResources = $form->getData();
            $courseInfo->removeCourseTutoringResource($tutoringResources);
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}