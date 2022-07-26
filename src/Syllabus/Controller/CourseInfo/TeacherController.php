<?php

namespace App\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Form\CourseInfo\Presentation\EditTeacherType;
use App\Syllabus\Form\CourseInfo\Presentation\RemoveTeacherType;
use App\Syllabus\Manager\CourseTeacherManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class TeachersController
 * @package App\Syllabus\Controller\CourseInfo
 * @Route("/course-info/teacher/{id}", name="app.course_info.teacher.")
 * @Security("is_granted('WRITE', teacher)")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/edit", name="edit"))
     * @param CourseTeacher $teacher
     * @param Request $request
     * @param CourseTeacherManager $courseTeacherManager
     * @param Environment $twig
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function editTeacherAction(
        CourseTeacher $teacher,
        Request $request,
        CourseTeacherManager $courseTeacherManager,
        Environment $twig
    ): JsonResponse
    {
        $form = $this->createForm(EditTeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $courseTeacherManager->update($teacher);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }

        return $this->json([
            'status' => true,
            'content' => $twig->render('course_info/presentation/form/edit_teacher.html.twig', [
                'form' => $form->createView()
            ])
        ]);
    }

    /**
     * @Route("/delete", name="delete"))
     *
     * @param CourseTeacher $teacher
     * @param Request $request
     * @param CourseTeacherManager $courseTeacherManager
     * @param Environment $twig
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function removeTeacherAction(
        CourseTeacher $teacher,
        Request $request,
        CourseTeacherManager $courseTeacherManager,
        Environment $twig
    ): JsonResponse
    {
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

        return $this->json([
            'status' => true,
            'content' => $twig->render('course_info/presentation/form/remove_teacher.html.twig', [
                'form' => $form->createView()
            ])
        ]);
    }

}