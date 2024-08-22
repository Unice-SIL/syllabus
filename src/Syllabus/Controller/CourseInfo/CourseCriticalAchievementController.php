<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseCriticalAchievement;
use App\Syllabus\Entity\LearningAchievement;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseCriticalAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\LearningAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\RemoveCourseCriticalAchievementType;
use App\Syllabus\Manager\CourseCriticalAchievementManager;
use Doctrine\ORM\EntityManagerInterface;
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
 * Class CourseCriticalAchievementController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Security("is_granted('WRITE', courseCriticalAchievement)")
 */
#[Route(path: '/course-info/critical-achievement/{id}', name: 'app.course_info.critical_achievement.')]
class CourseCriticalAchievementController extends AbstractController
{
    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/edit', name: 'edit')]
    public function editCriticalAchievementAction(CourseCriticalAchievement        $courseCriticalAchievement,
                                                  Request                          $request,
                                                  CourseCriticalAchievementManager $courseCriticalAchievementManager,
                                                  Environment                      $twig
    ): JsonResponse
    {
        $form = $this->createForm(CourseCriticalAchievementType::class, $courseCriticalAchievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseCriticalAchievementManager->update($courseCriticalAchievement);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $twig->render('course_info/objectives_course/form/edit_critical_achievement.html.twig', [
            'form' => $form->createView()
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
    #[Route(path: '/delete', name: 'delete')]
    public function deleteCriticalAchievementAction(CourseCriticalAchievement        $courseCriticalAchievement,
                                                    Request                          $request,
                                                    CourseCriticalAchievementManager $courseCriticalAchievementManager,
                                                    Environment                      $twig
    ): JsonResponse
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
        $render = $twig->render('course_info/objectives_course/form/remove_critical_achievement.html.twig', [
            'form' => $form->createView()
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
    #[Route(path: '/learning-achievement/add', name: 'learning_achievement.add')]
    public function addLearningAchievementAction(CourseCriticalAchievement $courseCriticalAchievement,
                                                 Request                   $request,
                                                 Environment               $twig,
                                                 EntityManagerInterface    $em
    ): Response
    {
        $learningAchievement = new LearningAchievement();
        $learningAchievement->setCourseCriticalAchievement($courseCriticalAchievement);
        $form = $this->createForm(LearningAchievementType::class, $learningAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($learningAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $twig->render('course_info/objectives_course/form/learning_achievement.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}