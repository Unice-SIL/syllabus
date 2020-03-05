<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\CourseAchievement\CourseAchievementType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCourseAchievementType;
use AppBundle\Manager\CourseAchievementManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course-info/achievement/{id}", name="app.course_info.achievement.")
 */
class AchievementController extends AbstractController
{
    /**
     * @Route("/create", name="create"))
     * @Security("is_granted('WRITE', courseInfo)")
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
     * @Route("/edit", name="edit"))
     * @Security("is_granted('WRITE', achievement)")
     *
     * @param CourseAchievement $achievement
     * @param Request $request
     * @param CourseAchievementManager $courseAchievementManager
     * @return JsonResponse
     */
    public function editAchievementAction(CourseAchievement $achievement, Request $request, CourseAchievementManager $courseAchievementManager)
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

        $render = $this->get('twig')->render('course_info/objectives_course/form/edit_achievement.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     * @Security("is_granted('WRITE', achievement)")
     *
     * @param CourseAchievement $achievement
     * @param Request $request
     * @param CourseAchievementManager $courseAchievementManager
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteAchievementAction(CourseAchievement $achievement, Request $request,
                                            CourseAchievementManager $courseAchievementManager)
    {
        if (!$achievement instanceof CourseAchievement) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : la compétence n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCourseAchievementType::class, $achievement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $courseAchievementManager->delete($achievement);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/objectives_course/form/remove_achievement.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}