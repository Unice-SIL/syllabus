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
        /*if ($dataAchievements)
        {
            foreach ($achievements as $achievement) {
                if (in_array($achievement->getId(), $dataAchievements)) {
                    $achievement->setPosition(array_search($achievement->getId(), $dataAchievements));
                }
            }
            $manager->update($courseInfo);
        }*/

        return $this->json([
            'status' => true,
            'content' => null
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
        $dataTutoringResources= $request->request->get('data');

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
        if ($data)
        {
            foreach ($courseInfoList as $item) {
                if (in_array($item->getId(), $data)) {
                    $item->setPosition(array_search($item->getId(), $data));
                }
            }
            $manager->update($courseInfo);
        }
    }
}