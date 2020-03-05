<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseCriticalAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseCriticalAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseCriticalAchievementType;
use AppBundle\Manager\CourseCriticalAchievementManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CriticalAchievementController
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/critical-achievement/{id}", name="app.course_info.critical_achievement.")
 */
class CriticalAchievementController extends AbstractController
{
    /**
     * @Route("/create", name="create"))
     * @Security("is_granted('WRITE', courseInfo)")
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
     * @Route("/edit", name="edit"))
     * @Security("is_granted('WRITE', criticalAchievement)")
     *
     * @param CourseCriticalAchievement $criticalAchievement
     * @param Request $request
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return JsonResponse
     */
    public function editCriticalAchievementAction(CourseCriticalAchievement $criticalAchievement, Request $request,
                                                  CourseCriticalAchievementManager $courseCriticalAchievementManager)
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
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     * @Security("is_granted('WRITE', criticalAchievement)")
     *
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @param Request $request
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return JsonResponse
     */
    public function deleteCriticalAchievementAction(CourseCriticalAchievement $courseCriticalAchievement,
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
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}