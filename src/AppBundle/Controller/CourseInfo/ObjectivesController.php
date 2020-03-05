<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Manager\CourseInfoManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course-info/{id}/objectives", name="app.course_info.objectives.")
 *
 * @Security("is_granted('WRITE', courseInfo)")
 */
class ObjectivesController extends AbstractController
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
     * @Route("/achievements", name="achievements"))
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
     * @Route("/critical-achievements", name="critical_achievements"))
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
        $criticalAchievements = $courseInfo->getCourseCriticalAchievements();
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
     * @Route("/prerequisites", name="prerequisites"))
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
     * @Route("/tutoring-resources", name="tutoring_resources"))
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
     * @Route("/tutoring-resources/sort", name="sort_tutoring_resources"))
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