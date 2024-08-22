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
 * @Security("is_granted('WRITE', teacher)")
 */
#[Route(path: '/course-info/teacher/{id}', name: 'app.course_info.teacher.')]
class TeacherController extends AbstractController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/edit', name: 'edit')]
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
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/delete', name: 'delete')]
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