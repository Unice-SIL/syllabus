<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseCriticalAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Entity\LearningAchievement;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAssistTutoringType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseCriticalAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseTutoringResourcesType;
use AppBundle\Form\CourseInfo\CourseAchievement\LearningAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseCriticalAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseTutoringResourcesType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveLearningAchievementType;
use AppBundle\Manager\CourseInfoManager;
use Doctrine\ORM\EntityManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseInfoObjectivesCourseController
 * @package AppBundle\Controller
 *
 * @Route("/course/{id}/objectives_course", name="objective_course_")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class CourseInfoObjectivesCourseController extends AbstractController
{
    /**
     * @Route("/", name="index")
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
     * @Route("/achievement/view", name="achievement_view"))
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
     * @Route("/achievement/form", name="achievement_form"))
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
     * @Route("/achievement/edit/{achievementId}", name="edit_achievement"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseAchievement $achievement
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("achievement", options={"mapping": {"achievementId": "id"}})
     */
    public function editAchievementAction(CourseInfo $courseInfo, CourseAchievement $achievement, Request $request)
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
     * @Route("/achievement/delete/{achievementId}", name="remove_achievement"))
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
     * @Route("/criticalAchievement/view", name="critical_achievement_view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function criticalAchievementViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/view/critical_achievement.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/criticalAchievement/form", name="critical_achievement_form"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @return Response
     */
    public function addCriticalAchievementAction(CourseInfo $courseInfo, Request $request)
    {
        $courseCriticalAchievement = new CourseCriticalAchievement();
        $courseCriticalAchievement->setCourseInfo($courseInfo);
        $form = $this->createForm(CourseCriticalAchievementType::class, $courseCriticalAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($courseCriticalAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/critical_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/criticalAchievement/edit/{criticalAchievementId}", name="critical_achievement_edit"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseCriticalAchievement $criticalAchievement
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("criticalAchievement", options={"mapping": {"criticalAchievementId": "id"}})
     */
    public function editCriticalAchievementAction(CourseInfo $courseInfo, CourseCriticalAchievement $criticalAchievement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CourseCriticalAchievementType::class, $criticalAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criticalAchievement = $form->getData();
            $em->persist($criticalAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_critical_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/criticalAchievement/delete/{criticalAchievementId}", name="critical_achievement_remove"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("courseCriticalAchievement", options={"mapping": {"criticalAchievementId": "id"}})
     */
    public function deleteCriticalAchievementAction(CourseInfo $courseInfo, CourseCriticalAchievement $courseCriticalAchievement,
                                                    Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RemoveCourseCriticalAchievementType::class, $courseCriticalAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CourseCriticalAchievement $courseCriticalAchievement */
            $courseCriticalAchievement = $form->getData();
            $em->remove($courseCriticalAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_critical_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/learningAchievement/view", name="learning_achievement_view"))
     *
     * @param CourseInfo $courseInfo
     * @return Response
     */
    public function learningAchievementViewAction(CourseInfo $courseInfo)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/view/critical_achievement.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/learningAchievement/{criticalAchievementId}/form", name="learning_achievement_form"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @return Response
     * @ParamConverter("courseCriticalAchievement", options={"mapping": {"criticalAchievementId": "id"}})
     */
    public function addLearningAchievementAction(CourseInfo $courseInfo, CourseCriticalAchievement $courseCriticalAchievement, Request $request)
    {
        $learningAchievement = new LearningAchievement();
        $learningAchievement->setCourseCriticalAchievement($courseCriticalAchievement);
        $form = $this->createForm(LearningAchievementType::class, $learningAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($learningAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/learning_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/learningAchievement/edit/{learningAchievementId}", name="learning_achievement_edit"))
     *
     * @param CourseInfo $courseInfo
     * @param LearningAchievement $learningAchievement
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("learningAchievement", options={"mapping": {"learningAchievementId": "id"}})
     */
    public function editLearningAchievementAction(CourseInfo $courseInfo, LearningAchievement $learningAchievement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(LearningAchievementType::class, $learningAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $learningAchievement = $form->getData();
            $em->persist($learningAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_learning_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/learningAchievement/delete/{learningAchievementId}", name="learning_achievement_remove"))
     *
     * @param CourseInfo $courseInfo
     * @param LearningAchievement $learningAchievement
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("learningAchievement", options={"mapping": {"learningAchievementId": "id"}})
     */
    public function deleteLearningAchievementAction(CourseInfo $courseInfo, LearningAchievement $learningAchievement,
                                                    Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RemoveLearningAchievementType::class, $learningAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var LearningAchievement $learningAchievement */
            $learningAchievement = $form->getData();
            $em->remove($learningAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_learning_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/prerequisite/view", name="prerequisite_view"))
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
     * @Route("objective_course/prerequisite/form", name="prerequisite_form"))
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
     * @Route("prerequisite/edit/{prerequisiteId}", name="edit_prerequisite"))
     *
     * @param CourseInfo $courseInfo
     * @param CoursePrerequisite $prerequisite
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("prerequisite", options={"mapping": {"prerequisiteId": "id"}})
     */
    public function editPrerequisiteAction(CourseInfo $courseInfo, CoursePrerequisite $prerequisite, Request $request)
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
     * @Route("prerequisite/delete/{prerequisiteId}", name="remove_prerequisite"))
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
     * @Route("tutoring_resources/view", name="tutoring_resources_view"))
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
     * @Route("tutoring_resources/form", name="tutoring_resources_form"))
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
     * @Route("tutoring_resources/edit/{tutoringResourcesId}", name="edit_tutoring_resources"))
     *
     * @param CourseInfo $courseInfo
     * @param CourseTutoringResource $tutoringResources
     * @param Request $request
     * @return JsonResponse
     * @ParamConverter("tutoringResources", options={"mapping": {"tutoringResourcesId": "id"}})
     */
    public function editTutoringResourceAction(CourseInfo $courseInfo, CourseTutoringResource $tutoringResources, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(CourseTutoringResourcesType::class, $tutoringResources);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tutoringResources = $form->getData();
            $em->persist($tutoringResources);
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
     * @Route("tutoring_resources/delete/{tutoringResourcesId}", name="remove_tutoring_resources"))
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
     * @Route("tutoring/form", name="tutoring_form"))
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
     * @Route("tutoring/{action}", name="active_tutoring"))
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