<?php


namespace AppBundle\Controller\CourseInfo;


use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Permission\AddCourseInfoPermissionType;
use AppBundle\Manager\CoursePermissionManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PermissionController
 * @package AppBundle\Controller\CourseInfo
 *
 * @Route("/course-info/{id}/permissions", name="app.course_info.permission.")
 * @Security("is_granted('WRITE', courseInfo)")
 */
class PermissionController extends AbstractController
{
    /**
     * @Route("/", name="index")
     *
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param CoursePermissionManager $coursePermissionManager
     * @return RedirectResponse|Response
     */
    public function indexAction(CourseInfo $courseInfo, Request $request, CoursePermissionManager $coursePermissionManager)
    {
        $coursePermission = $coursePermissionManager->new($courseInfo);
        $form = $this->createForm(AddCourseInfoPermissionType::class, $coursePermission);
        $form->handleRequest($request);

        $isValid = true;
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $coursePermissionManager->create($coursePermission);

                $this->addFlash('success', 'La permission a été ajoutée avec succès');
                return $this->redirectToRoute('app_course_permission', ['id' => $courseInfo->getId()]);
            }
            $isValid = false;
        }

        //todo: add addSelect to get coursePermission and user with courseInfo
        return $this->render('course_info/permission/index.html.twig', array(
            'courseInfo' => $courseInfo,
            'form' => $form->createView(),
            'isValid' => $isValid
        ));
    }
}