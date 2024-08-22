<?php


namespace App\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Form\CourseInfo\Permission\AddCourseInfoPermissionType;
use App\Syllabus\Manager\CoursePermissionManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CoursePermissionController
 * @package App\Syllabus\Controller\CourseInfo
 *
 * @Security("is_granted('WRITE', courseInfo)")
 */
#[Route(path: '/course-info/{id}/permissions', name: 'app.course_info.permission.')]
class CoursePermissionController extends AbstractController
{
    
    #[Route(path: '/', name: 'index')]
    public function indexAction(CourseInfo $courseInfo, Request $request, CoursePermissionManager $coursePermissionManager, TranslatorInterface $translator): RedirectResponse|Response
    {
        $coursePermission = $coursePermissionManager->new($courseInfo);
        $form = $this->createForm(AddCourseInfoPermissionType::class, $coursePermission);
        $form->handleRequest($request);

        $isValid = true;
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $coursePermissionManager->create($coursePermission);

                $this->addFlash('success', $translator->trans('app.controller.course_permission.add_permission'));
                return $this->redirectToRoute('app.course_info.permission.index', ['id' => $courseInfo->getId()]);
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