<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Constant\Permission;
use AppBundle\Entity\CoursePermission;
use AppBundle\Form\CourseInfo\Permission\RemoveCoursePermissionType;
use AppBundle\Manager\CoursePermissionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PermissionController
 * @package AppBundle\Controller\CourseInfo
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
     * @return mixed
     */
    public function deleteAction(CoursePermission $permission, Request $request, CoursePermissionManager $coursePermissionManager)
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
        $render = $this->get('twig')->render('course_info/permission/form/remove.html.twig', [
            'form' => $form->createView()
        ]);
        return $this->json([
            'status' => true,
            'content' => $render
        ]);
    }
}