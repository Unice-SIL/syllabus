<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Form\CourseInfo\Permission\RemoveCoursePermissionType;
use App\Syllabus\Manager\CoursePermissionManager;
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
 * Class PermissionController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Route("/course-info/permissions/{id}", name="app.course_info.permission.")
 */
class PermissionController extends AbstractController
{
    /**
     * @Route("/delete", name="delete")
     *
     * @param CoursePermission $permission
     * @param Request $request
     * @param CoursePermissionManager $coursePermissionManager
     * @param Environment $twig
     * @return JsonResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteAction(CoursePermission        $permission,
                                 Request                 $request,
                                 CoursePermissionManager $coursePermissionManager,
                                 Environment             $twig
    ): JsonResponse
    {
        $form = $this->createForm(RemoveCoursePermissionType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coursePermissionManager->delete($permission);
            return $this->json([
                'status' => true,
                'content' => null
            ]);
        }
        $render = $twig->render('course_info/permission/form/remove.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}