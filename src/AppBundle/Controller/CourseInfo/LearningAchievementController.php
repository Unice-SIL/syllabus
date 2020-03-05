<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseCriticalAchievement;
use AppBundle\Entity\LearningAchievement;
use AppBundle\Form\CourseInfo\CourseAchievement\LearningAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveLearningAchievementType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LearningAchievement
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/learning-achievement/{id}", name="app.course_info.learning_achievement.")
 */
class LearningAchievementController extends AbstractController
{
    /**
     * @Route("/create", name="create"))
     * @Security("is_granted('WRITE', courseCriticalAchievement)")
     *
     * @param Request $request
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @return Response
     */
    public function addLearningAchievementAction(CourseCriticalAchievement $courseCriticalAchievement, Request $request)
    {
        $learningAchievement = new LearningAchievement();
        $learningAchievement->setCourseCriticalAchievement($courseCriticalAchievement);
        $form = $this->createForm(LearningAchievementType::class, $learningAchievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($learningAchievement);
            $em->flush();
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/objectives_course/form/learning_achievement.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/edit", name="edit"))
     * @Security("is_granted('WRITE', learningAchievement)")
     *
     * @param LearningAchievement $learningAchievement
     * @param Request $request
     * @return JsonResponse
     */
    public function editLearningAchievementAction(LearningAchievement $learningAchievement, Request $request)
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
    }

    /**
     * @Route("/delete", name="delete"))
     * @Security("is_granted('WRITE', learningAchievement)")
     *
     * @param LearningAchievement $learningAchievement
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteLearningAchievementAction(LearningAchievement $learningAchievement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
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
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_learning_achievement.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}