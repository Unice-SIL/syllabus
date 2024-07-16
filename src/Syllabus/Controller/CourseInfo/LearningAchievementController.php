<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\LearningAchievement;
use App\Syllabus\Form\CourseInfo\CourseAchievement\LearningAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\RemoveLearningAchievementType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class LearningAchievement
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/learning-achievement/{id}", name="app.course_info.learning_achievement.")
 * @Security("is_granted('WRITE', learningAchievement)")
 */
class LearningAchievementController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
     *
     * @param LearningAchievement $learningAchievement
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Environment $twig
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function editLearningAchievementAction(
        LearningAchievement $learningAchievement,
        Request $request,
        EntityManagerInterface $em,
        Environment $twig
    ): JsonResponse
    {
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

        $render = $twig->render('course_info/objectives_course/form/edit_learning_achievement.html.twig', [
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
     * @param LearningAchievement $learningAchievement
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Environment $twig
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteLearningAchievementAction(
        LearningAchievement $learningAchievement,
        Request $request,
        EntityManagerInterface $em,
        Environment $twig
    ): JsonResponse
    {
        $form = $this->createForm(RemoveLearningAchievementType::class, $learningAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var LearningAchievementController $learningAchievement */
            $learningAchievement = $form->getData();
            $em->remove($learningAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $twig->render('course_info/objectives_course/form/remove_learning_achievement.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}