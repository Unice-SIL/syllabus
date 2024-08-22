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
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AchievementController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Security("is_granted('WRITE', achievement)")
 */
#[Route(path: '/course-info/achievement/{id}', name: 'app.course_info.achievement.')]
class AchievementController extends AbstractController
{
    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/edit', name: 'edit')]
    public function editAchievementAction(Environment $twig, CourseAchievement $achievement, Request $request, CourseAchievementManager $courseAchievementManager): JsonResponse
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
        $render = $twig->render('course_info/objectives_course/form/edit_achievement.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/delete', name: 'delete')]
    public function deleteAchievementAction(Environment $twig, CourseAchievement $achievement, Request $request,
                                            CourseAchievementManager $courseAchievementManager): JsonResponse
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