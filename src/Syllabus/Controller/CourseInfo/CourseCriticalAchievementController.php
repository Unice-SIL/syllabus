<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseCriticalAchievement;
use App\Syllabus\Entity\LearningAchievement;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CourseCriticalAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\LearningAchievementType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\RemoveCourseCriticalAchievementType;
use App\Syllabus\Manager\CourseCriticalAchievementManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CourseCriticalAchievementController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/critical-achievement/{id}", name="app.course_info.critical_achievement.")
 * @Security("is_granted('WRITE', courseCriticalAchievement)")
 */
class CourseCriticalAchievementController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
     *
     * @param CourseCriticalAchievement $courseCriticalAchievement
     * @param Request $request
     * @param CourseCriticalAchievementManager $courseCriticalAchievementManager
     * @return JsonResponse
     */
    public function editCriticalAchievementAction(CourseCriticalAchievement $courseCriticalAchievement, Request $request,
                                                  CourseCriticalAchievementManager $courseCriticalAchievementManager)
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

    /**
     * @Route("/learning-achievement/add", name="learning_achievement.add"))
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
}