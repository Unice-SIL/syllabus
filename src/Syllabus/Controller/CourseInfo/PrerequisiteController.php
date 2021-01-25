<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CoursePrerequisite;
use App\Syllabus\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use App\Syllabus\Form\CourseInfo\CourseAchievement\RemoveCoursePrerequisiteType;
use App\Syllabus\Manager\CoursePrerequisiteManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PrerequisiteController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/prerequisite/{id}", name="app.course_info.prerequisite.")
 * @Security("is_granted('WRITE', prerequisite)")
 */
class PrerequisiteController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
     *
     * @param CoursePrerequisite $prerequisite
     * @param Request $request
     * @param CoursePrerequisiteManager $coursePrerequisiteManager
     * @return JsonResponse
     */
    public function editPrerequisiteAction(CoursePrerequisite $prerequisite, Request $request,
                                           CoursePrerequisiteManager $coursePrerequisiteManager)
    {
        $form = $this->createForm(CoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursePrerequisiteManager->update($prerequisite);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/prerequisite/form/edit_prerequisite.html.twig', [
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
     * @param CoursePrerequisite $prerequisite
     * @param Request $request
     * @param CoursePrerequisiteManager $coursePrerequisiteManager
     * @return JsonResponse
     */
    public function deletePrerequisitesAction(CoursePrerequisite $prerequisite, Request $request,
                                              CoursePrerequisiteManager $coursePrerequisiteManager)
    {
        $form = $this->createForm(RemoveCoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursePrerequisiteManager->delete($prerequisite);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/prerequisite/form/remove_prerequisite.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}