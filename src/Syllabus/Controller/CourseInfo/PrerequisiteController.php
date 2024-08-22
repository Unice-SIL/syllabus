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
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PrerequisiteController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Security("is_granted('WRITE', prerequisite)")
 */
#[Route(path: '/course-info/prerequisite/{id}', name: 'app.course_info.prerequisite.')]
class PrerequisiteController extends AbstractController
{
    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/edit', name: 'edit')]
    public function editPrerequisiteAction(
        CoursePrerequisite $prerequisite,
        Request $request,
        CoursePrerequisiteManager $coursePrerequisiteManager,
        Environment $twig
    ): JsonResponse
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

        $render = $twig->render('course_info/prerequisite/form/edit_prerequisite.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }

    /**
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    #[Route(path: '/delete', name: 'delete')]
    public function deletePrerequisitesAction(
        CoursePrerequisite $prerequisite,
        Request $request,
        CoursePrerequisiteManager $coursePrerequisiteManager,
        Environment $twig
    ): JsonResponse
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
        $render = $twig->render('course_info/prerequisite/form/remove_prerequisite.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}