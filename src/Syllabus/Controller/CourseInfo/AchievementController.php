<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\RemoveCourseAchievementType;
use App\Syllabus\Manager\CourseAchievementManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * Class AchievementController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/achievement/{id}", name="app.course_info.achievement.")
 * @Security("is_granted('WRITE', achievement)")
 */
class AchievementController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
     *
     * @param CourseAchievement $achievement
     * @param Request $request
     * @param CourseAchievementManager $courseAchievementManager
     * @return JsonResponse
     */
    public function editAchievementAction(Environment $twig, CourseAchievement $achievement, Request $request, CourseAchievementManager $courseAchievementManager)
    {
        $form = $this->createForm(CourseAchievementType::class, $achievement);
        $form->handleRequest($request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseAchievementManager->update($achievement);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $twig->render('course_info/objectives_course/form/edit_achievement.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     *
     * @param Environment $twig
     * @param CourseAchievement $achievement
     * @param Request $request
     * @param CourseAchievementManager $courseAchievementManager
     * @param TranslatorInterface $translator
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteAchievementAction(Environment $twig, CourseAchievement $achievement, Request $request,
                                            CourseAchievementManager $courseAchievementManager)
    {
        $form = $this->createForm(RemoveCourseAchievementType::class, $achievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseAchievementManager->delete($achievement);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $twig->render('course_info/objectives_course/form/remove_achievement.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}