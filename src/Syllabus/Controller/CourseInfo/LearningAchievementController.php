<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\LearningAchievement;
use App\Syllabus\Form\CourseInfo\CourseAchievement\LearningAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\RemoveLearningAchievementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return JsonResponse
     */
   /* public function editLearningAchievementAction(LearningAchievement $learningAchievement, Request $request)
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
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }*/

    /**
     * @Route("/delete", name="delete"))
     *
     * @param LearningAchievement $learningAchievement
     * @param Request $request
     * @return JsonResponse
     */
  /*  public function deleteLearningAchievementAction(LearningAchievement $learningAchievement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RemoveLearningAchievementType::class, $learningAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {*/
            /** @var LearningAchievementController $learningAchievement */
        /*    $learningAchievement = $form->getData();
            $em->remove($learningAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_learning_achievement.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }*/
}