<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseInfo;
use AppBundle\Form\CourseInfo\Permission\AddCourseInfoPermissionType;
use AppBundle\Manager\CoursePermissionManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * CoursePermission controller.
 *
 */
class CoursePermissionController extends Controller
{
    /**
     * Lists all CoursePermission entities.
     *
     * @Route("/course/{id}/permissions", name="app_course_permission")
     * @Method("GET")
     * @Security("is_granted('WRITE', courseInfo)")
     * @param CourseInfo $courseInfo
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param CoursePermissionManager $coursePermissionManager
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function indexAction(CourseInfo $courseInfo, Request $request, EntityManagerInterface $em, CoursePermissionManager $coursePermissionManager)
    {

        $coursePermission = $coursePermissionManager->create();
        $coursePermission->setCourseInfo($courseInfo);
        $form = $this->createForm(AddCourseInfoPermissionType::class, $coursePermission);
        $form->handleRequest($request);

        $isValid = true;
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $em->persist($coursePermission);
                $em->flush();

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
