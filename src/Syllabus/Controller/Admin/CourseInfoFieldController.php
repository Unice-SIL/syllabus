<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\CourseInfoField;
use App\Syllabus\Form\CourseInfoFieldDynamicType;
use App\Syllabus\Form\CourseInfoFieldType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * CourseInfoField controller.
 */
#[Route(path: '/syllabus-import-field', name: 'app.admin.course_info_field.')]
class CourseInfoFieldController extends AbstractController
{
    /**
     * Lists all CourseInfoField entities.
     *
     */
    #[Route(path: '/', name: 'index')]
    public function indexAction(Request $request, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(CourseInfoFieldDynamicType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            //redirect + flashbag
            $this->addFlash('success', $translator->trans('admin.course_info_field.flashbag.success'));

            return $this->redirectToRoute('app.admin.course_info_field.index');

        }
        return $this->render('course_info_field/index.html.twig', array(
            'formView' => $form->createView(),
        ));
    }


    /**
     * Edit a CourseInfoField entity
     */
    #[Route(path: '/{id}/edit', name: 'edit', methods: ['POST'])]
    public function editAction(EntityManagerInterface $entityManager, CourseInfoField $courseInfoField, Request $request): JsonResponse
    {
        $form = $this->createForm(CourseInfoFieldType::class, $courseInfoField);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false]);
    }
}
