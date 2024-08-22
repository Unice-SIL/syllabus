<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseCriticalAchievementType;
use App\Syllabus\Manager\CourseAchievementManager;
use App\Syllabus\Manager\CourseCriticalAchievementManager;
use App\Syllabus\Manager\CourseInfoManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ObjectivesController
 * @package App\Syllabus\Controller\CourseInfo
 * @Security("is_granted('WRITE', courseInfo)")
 */
#[Route(path: '/course-info/{id}/objectives', name: 'app.course_info.objectives.')]
class ObjectivesController extends AbstractController
{
    
    #[Route(path: '/', name: 'index')]
    public function indexAction(CourseInfo $courseInfo): Response
    {
        return $this->render('course_info/objectives_course/objectives_course.html.twig', [
            'courseInfo' => $courseInfo
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/achievements', name: 'achievements')]
    public function achievementViewAction(CourseInfo $courseInfo, Environment $twig): Response
    {
        $render = $twig->render('course_info/objectives_course/view/achievement.html.twig', [
            'courseInfo' => $courseInfo
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/achievement/add', name: 'achievement.add')]
    public function addAchievementAction(CourseInfo $courseInfo, Request $request, CourseAchievementManager $courseAchievementManager, Environment $twig): Response
    {
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

        $render = $twig->render('course_info/objectives_course/form/achievement.html.twig', [
            'courseInfo' => $courseInfo,
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route(path: '/achievements/sort', name: 'sort_achievements')]
    public function sortAchievementsAction(CourseInfo $courseInfo, Request $request, CourseInfoManager $manager): JsonResponse
    {
        $achievements = $courseInfo->getCourseAchievements();
        $dataAchievements = $request->request->all('data');

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
     * @param Environment $twig
     * @return Response
     */
    /* public function criticalAchievementViewAction(CourseInfo $courseInfo, Environment $twig)
       {
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
           $render = $twig->render('course_info/objectives_course/view/critical_achievement.html.twig', [
               'courseInfo' => $courseInfo,
               'tabValideScore' => $tabValideScore
           ]);
           return $this->json([
               'status' => true,
               'content' => $render
           ]);
       }*/
    /**
     * @Route("critical-achievement/add", name="critical_achievement.add"))
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param Environment $twig
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return Response
     */
    /*public function addCriticalAchievementAction(CourseInfo $courseInfo, Request $request,
                                                     CourseCriticalAchievementManager $courseCriticalAchievementManager,
                                                     Environment $twig
        )
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
    
            $render = $twig->render('course_info/objectives_course/form/critical_achievement.html.twig', [
                'courseInfo' => $courseInfo,
                'form' => $form->createView()
            ]);
            return $this->json([
                'status' => true,
                'content' => $render
            ]);
        }*/
    /**
     * @param $courseInfoList
     * @param $data
     * @throws Exception
     */
    private function sortList(CourseInfo $courseInfo, $courseInfoList, $data, CourseInfoManager $manager): void
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