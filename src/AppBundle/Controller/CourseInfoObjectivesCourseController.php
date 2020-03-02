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
use AppBundle\Manager\CourseAchievementManager;
use AppBundle\Manager\CourseCriticalAchievementManager;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CoursePrerequisiteManager;
use AppBundle\Manager\CourseTutoringResourceManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @param CourseAchievementManager $courseAchievementManager
     * @return Response
     */
    public function addAchievementAction(CourseInfo $courseInfo, Request $request, CourseAchievementManager $courseAchievementManager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $courseAchievement = $courseAchievementManager->new($courseInfo);
        $form = $this->createForm(CourseAchievementType::class, $courseAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseAchievementManager->create($courseAchievement);

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
     * @param CourseAchievementManager $courseAchievementManager
     * @return JsonResponse
     * @ParamConverter("achievement", options={"mapping": {"achievementId": "id"}})
     */
    public function editAchievementAction(CourseInfo $courseInfo, CourseAchievement $achievement, Request $request, CourseAchievementManager $courseAchievementManager)
    {
        $form = $this->createForm(CourseAchievementType::class, $achievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseAchievementManager->update($achievement);
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
     * @param CourseAchievementManager $courseAchievementManager
     * @return JsonResponse
     * @ParamConverter("achievement", options={"mapping": {"achievementId": "id"}})
     * @throws Exception
     */
    public function deleteAchievementAction(CourseInfo $courseInfo, CourseAchievement $achievement, Request $request, CourseAchievementManager $courseAchievementManager)
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
            $courseAchievementManager->delete($achievement);
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
     * @Route("/achievements/sort", name="sort_achievements"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function sortAchievementsAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        $achievements = $courseInfo->getCourseAchievements();
        $dataAchievements = $request->request->get('data');

        $this->sortList($courseInfo, $achievements, $dataAchievements, $manager);

        return $this->json([
            'status' => true,
            'content' => null
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
        $CriticalAchievements = $courseInfo->getCourseCriticalAchievements();
        $tabValideScore = [];
        foreach ($criticalAchievements as $ca) {
            $scoreTotal = 0;
            $score = 0;
            if ($ca->getRule() == 'Score') {
                $scoreTotal = $ca->getScore();
                foreach ($ca->getLearningAchievements() as $la) {
                    $score += $la->getScore();
                }
            }
            if ($score >= $scoreTotal) {
                $tabValideScore[] = $ca->getId();
            }
        }
        $render = $this->get('twig')->render('course_info/objectives_course/view/critical_achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'tabValideScore' => $tabValideScore
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
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return Response
     */
    public function addCriticalAchievementAction(CourseInfo $courseInfo, Request $request, CourseCriticalAchievementManager $courseCriticalAchievementManager)
    {
        $courseCriticalAchievement = $courseCriticalAchievementManager->new($courseInfo);
        $form = $this->createForm(CourseCriticalAchievementType::class, $courseCriticalAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseCriticalAchievementManager->create($courseCriticalAchievement);
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
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return JsonResponse
     * @ParamConverter("criticalAchievement", options={"mapping": {"criticalAchievementId": "id"}})
     */
    public function editCriticalAchievementAction(CourseInfo $courseInfo, CourseCriticalAchievement $criticalAchievement, Request $request, CourseCriticalAchievementManager $courseCriticalAchievementManager)
    {
        $form = $this->createForm(CourseCriticalAchievementType::class, $criticalAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseCriticalAchievementManager->update($criticalAchievement);
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
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return JsonResponse
     * @ParamConverter("courseCriticalAchievement", options={"mapping": {"criticalAchievementId": "id"}})
     */
    public function deleteCriticalAchievementAction(CourseInfo $courseInfo, CourseCriticalAchievement $courseCriticalAchievement,
                                                    Request $request, CourseCriticalAchievementManager $courseCriticalAchievementManager)
    {
        $form = $this->createForm(RemoveCourseCriticalAchievementType::class, $courseCriticalAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseCriticalAchievementManager->delete($courseCriticalAchievement);
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
            foreach ($courseInfo->getCoursePrerequisites() as $prerequisite) {
                $prerequisite->setPosition($prerequisite->getPosition() + 1);
            }
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
     * @param CoursePrerequisiteManager $coursePrerequisiteManager
     * @return JsonResponse
     * @ParamConverter("prerequisite", options={"mapping": {"prerequisiteId": "id"}})
     */
    public function editPrerequisiteAction(CourseInfo $courseInfo, CoursePrerequisite $prerequisite, Request $request, CoursePrerequisiteManager $coursePrerequisiteManager)
    {
        $form = $this->createForm(CoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursePrerequisiteManager->update($prerequisite);
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
     * @param CoursePrerequisiteManager $coursePrerequisiteManager
     * @return JsonResponse
     * @ParamConverter("prerequisite", options={"mapping": {"prerequisiteId": "id"}})
     */
    public function deletePrerequisitesAction(CourseInfo $courseInfo, CoursePrerequisite $prerequisite, Request $request, CoursePrerequisiteManager $coursePrerequisiteManager)
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
            $coursePrerequisiteManager->delete($prerequisite);
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
     * @Route("/prerequisites/sort", name="sort_prerequisites"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function sortPrerequisitesAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        $prerequisites = $courseInfo->getCoursePrerequisites();
        $dataPrerequisites = $request->request->get('data');

        $this->sortList($courseInfo, $prerequisites, $dataPrerequisites, $manager);

        return $this->json([
            'status' => true,
            'content' => null
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
     * @param CourseTutoringResourceManager $courseTutoringResourceManager
     * @return Response
     */
    public function addTutoringResourceAction(CourseInfo $courseInfo, Request $request, CourseTutoringResourceManager $courseTutoringResourceManager)
    {
        if (!$courseInfo instanceof CourseInfo) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : Le cours n'existe pas."
            ]);
        }

        $tutoringResource = $courseTutoringResourceManager->new();
        $form = $this->createForm(CourseTutoringResourcesType::class, $tutoringResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseTutoringResourceManager->create($tutoringResource);

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
     * @param CourseTutoringResource $tutoringResource
     * @param Request $request
     * @param CourseTutoringResourceManager $courseTutoringResourceManager
     * @return JsonResponse
     * @ParamConverter("tutoringResources", options={"mapping": {"tutoringResourcesId": "id"}})
     */
    public function editTutoringResourceAction(CourseInfo $courseInfo, CourseTutoringResource $tutoringResource, Request $request, CourseTutoringResourceManager $courseTutoringResourceManager)
    {
        $form = $this->createForm(CourseTutoringResourcesType::class, $tutoringResource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseTutoringResourceManager->update($tutoringResource);
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
     * @param CourseTutoringResource $tutoringResource
     * @param Request $request
     * @param CourseTutoringResourceManager $courseTutoringResourceManager
     * @return JsonResponse
     * @ParamConverter("tutoringResources", options={"mapping": {"tutoringResourcesId": "id"}})
     */
    public function deleteTutoringResourcesAction(CourseInfo $courseInfo, CourseTutoringResource $tutoringResource, Request $request, CourseTutoringResourceManager $courseTutoringResourceManager)
    {
        if (!$tutoringResource instanceof CourseTutoringResource) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : la remédiation n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCourseTutoringResourcesType::class, $tutoringResource);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseTutoringResourceManager->delete($tutoringResource);

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
            foreach ($courseInfo->getCourseTutoringResources() as $tutoringResource) {
                $tutoringResource->setPosition($tutoringResource->getPosition() + 1);
            }
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

    /**
     * @Route("/tutoringResources/sort", name="sort_tutoring_resources"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function sortTutoringResourcesAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager)
    {
        $tutoringResources = $courseInfo->getCourseTutoringResources();
        $dataTutoringResources = $request->request->get('data');

        $this->sortList($courseInfo, $tutoringResources, $dataTutoringResources, $manager);

        return $this->json([
            'status' => true,
            'content' => null
        ]);
    }

    /**
     * @param CourseInfo $courseInfo
     * @param $courseInfoList
     * @param $data
     * @param CourseInfoManager $manager
     * @throws Exception
     */
    private function sortList(CourseInfo $courseInfo, $courseInfoList, $data, CourseInfoManager $manager)
    {
        if ($data) {
            foreach ($courseInfoList as $item) {
                if (in_array($item->getId(), $data)) {
                    $item->setPosition(array_search($item->getId(), $data));
                }
            }
            $manager->update($courseInfo);
        }
    }
}