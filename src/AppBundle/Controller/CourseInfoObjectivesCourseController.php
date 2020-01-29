<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAssistTutoringType;
use AppBundle\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseTutoringResourcesType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseTutoringResourcesType;
use AppBundle\Manager\CourseInfoManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseInfoObjectivesCourseController extends Controller
{
    /**
     * @Route("/course/{id}/objectives_course", name="course_info_objectives")
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function indexAction(CourseInfo $courseInfo)
    {
        return $this->render('course_info/objectives_course/objectives_course.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/achievement/view", name="objective_course_achievement_view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function achievementViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/view/achievement.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/achievement", name="objective_course_achievement"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return Response
     * @throws Exception
     */
    public function addAchievementAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
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
     * @Route("/course/objective_course/edit/achievement/{id}", name="objective_course_edit_achievement"))
     *
     * @param CourseAchievement $achievement
     * @param Request $request
     * @return JsonResponse
     */
    public function editAchievementAction(CourseAchievement $achievement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CourseAchievementType::class, $achievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $achievement = $form->getData();
            $em->persist($achievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_achievement.html.twig', [
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
     * @param CourseInfo $courseInfo
     * @param CourseAchievement $achievement
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws Exception
     * @ParamConverter("achievement", options={"mapping": {"achievementId": "id"}})
     */
    public function deleteAchievementAction(CourseInfo $courseInfo, CourseAchievement $achievement, Request $request, CourseInfoManager $manager)
    {
        if (!$achievement instanceof CourseAchievement) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : la compétence n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCourseAchievementType::class, $achievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/course/{id}/objective_course/prerequisite/view", name="objective_course_prerequisite_view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function prerequisiteViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/view/prerequisite.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/prerequisite", name="objective_course_prerequisite"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return Response
     * @throws Exception
     */
    public function addPrerequisiteAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
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
     * @Route("/course/objective_course/edit/prerequisite/{id}", name="objective_course_edit_prerequisite"))
     *
     * @param CoursePrerequisite $prerequisite
     * @param Request $request
     * @return JsonResponse
     */
    public function editPrerequisiteAction(CoursePrerequisite $prerequisite, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prerequisite = $form->getData();
            $em->persist($prerequisite);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_prerequisite.html.twig', [
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
     * @param CourseInfo $courseInfo
     * @param CoursePrerequisite $prerequisite
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws Exception
     * @ParamConverter("prerequisite", options={"mapping": {"prerequisiteId": "id"}})
     */
    public function deletePrerequisitesAction(CourseInfo $courseInfo, CoursePrerequisite $prerequisite, Request $request, CourseInfoManager $manager)
    {
        if (!$prerequisite instanceof CoursePrerequisite) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le prérequis n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/course/{id}/objective_course/tutoring_resources/view", name="objective_course_tutoring_resources_view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function tutoringResourcesViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/view/tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/tutoring_resources", name="objective_course_tutoring_resources"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return Response
     * @throws Exception
     */
    public function addTutoringResourceAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
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
     * @Route("/course/objective_course/edit/tutoring_resources/{id}", name="objective_course_edit_tutoring_resources"))
     *
     * @param CourseTutoringResource $tutoringResource
     * @param Request $request
     * @return JsonResponse
     */
    public function editTutoringResourceAction(CourseTutoringResource $tutoringResource, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(CourseTutoringResourcesType::class, $tutoringResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tutoringResource = $form->getData();
            $em->persist($tutoringResource);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_tutoring_resources.html.twig', [
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
     * @param CourseInfo $courseInfo
     * @param CourseTutoringResource $tutoringResources
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws Exception
     * @ParamConverter("tutoringResources", options={"mapping": {"tutoringResourcesId": "id"}})
     */
    public function deleteTutoringResourcesAction(CourseInfo $courseInfo, CourseTutoringResource $tutoringResources, Request $request, CourseInfoManager $manager)
    {
        if (!$tutoringResources instanceof CourseTutoringResource) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : la remédiation n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCourseTutoringResourcesType::class, $tutoringResources);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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

    /**
     * @Route("/course/{id}/objective_course/tutoring", name="objective_course_tutoring"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseInfoManager $manager
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function addTutoringAction(CourseInfo $courseInfo, CourseInfoManager $manager, Request $request)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }
        $form = $this->createForm(CourseAssistTutoringType::class, $courseInfo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseInfo = $form->getData();
            $manager->update($courseInfo);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/assist_tutoring.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/course/{id}/objective_course/tutoring/{action}", name="objective_course_active_tutoring"))
     *
     * @param CourseInfo $courseInfo
     * @param $action
     * @param CourseInfoManager $manager
     * @return JsonResponse
     * @throws Exception
     */
    public function activeTutoringAction(CourseInfo $courseInfo, $action, CourseInfoManager $manager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $courseInfo->setTutoring($action);
        $manager->update($courseInfo);

        $render = $this->get('twig')->render('course_info/objectives_course/view/tutoring_resources.html.twig', [
            'courseInfo' => $courseInfo
        ]);

        return $this->json([
            'status' => $action,
            'content' => $render
        ]);
    }
}