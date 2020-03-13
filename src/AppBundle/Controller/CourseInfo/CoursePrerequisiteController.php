<?php

namespace AppBundle\Controller\CourseInfo;

use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Form\CourseInfo\CourseAchievement\CoursePrerequisiteType;
use AppBundle\Form\CourseInfo\CourseAchievement\RemoveCoursePrerequisiteType;
use AppBundle\Manager\CoursePrerequisiteManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CoursePrerequisiteController
 * @package AppBundle\Controller\CourseInfo
 * @Route("/course-info/prerequisite/{id}", name="app.course_info.prerequisite.")
 * @Security("is_granted('WRITE', prerequisite)")
 */
class CoursePrerequisiteController extends AbstractController
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

        $render = $this->get('twig')->render('course_info/prerequisites/form/edit_prerequisite.html.twig', [
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
        if (!$prerequisite instanceof CoursePrerequisiteController) {
            return $this->json([
                'status' => false,
                'content' => "Une erreur est survenue : le prérequis n'existe pas"
            ]);
        }
        $form = $this->createForm(RemoveCoursePrerequisiteType::class, $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursePrerequisiteManager->delete($prerequisite);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $this->get('twig')->render('course_info/prerequisites/form/remove_prerequisite.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

}