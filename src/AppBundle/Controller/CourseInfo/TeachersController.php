<?php

namespace AppBundle\Controller\CourseInfo;

use AppBundle\Entity\CourseTeacher;
use AppBundle\Form\CourseInfo\Presentation\RemoveTeacherType;
use AppBundle\Manager\CourseTeacherManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeachersController
 * @package AppBundle\Controller\CourseInfo
 * @Route("/course-info/teacher/{id}", name="app.course_info.teacher.")
 * @Security("is_granted('WRITE', teacher)")
 */
class TeachersController extends AbstractController
{

    /**
     * @Route("/delete", name="delete"))
     *
     * @param CourseTeacher $teacher
     * @param Request $request
     * @param CourseTeacherManager $courseTeacherManager
     * @return JsonResponse
     */
    public function removeTeacherAction(CourseTeacher $teacher, Request $request, CourseTeacherManager $courseTeacherManager)
    {
        if (!$teacher instanceof CourseTeacher)
        {
            return $this->json([
                'status' => false,
                'render' => "Une erreur est survenue : L'enseignant n'existe pas"
            ]);
        }

        $form = $this->createForm(RemoveTeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $courseTeacherManager->delete($teacher);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        $render = $this->get('twig')->render('course_info/presentation/form/remove_teacher.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}