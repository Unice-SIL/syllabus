<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseCriticalAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseTutoringResourcesType;
use AppBundle\Manager\CourseAchievementManager;
use AppBundle\Manager\CourseCriticalAchievementManager;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseTutoringResourceManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ObjectivesController
 * @package AppBundle\Controller\CourseInfo
 * @Route("/course-info/{id}/objectives", name="app.course_info.objectives.")
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
     * @Route("/achievement/add", name="achievement.add"))
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
     * @Route("/achievements/sort", name="sort_achievements"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseInfoManager $manager
     * @return JsonResponse
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
     * @Route("critical-achievement/add", name="critical_achievement.add"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return Response
     */
    public function addCriticalAchievementAction(CourseInfo $courseInfo, Request $request,
                                                 CourseCriticalAchievementManager $courseCriticalAchievementManager)
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