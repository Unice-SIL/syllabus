<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\CourseInfoField;
use App\Syllabus\Form\CourseInfoFieldType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * CourseInfoField controller.
 *
 * @Route("/syllabus-import-field", name="app.admin.course_info_field.")
 */
class CourseInfoFieldController extends Controller
{
    /**
     * Lists all CourseInfoField entities.
     * @Route("/", name="index")
     *
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function indexAction(EntityManagerInterface $em)
    {

        $form = $this->createForm(CourseInfoFieldType::class, null, ['method' => 'POST']);

        return $this->render('course_info_field/index.html.twig', array(
            'courseInfoFields' => $em->getRepository(CourseInfoField::class)->findAll(),
            'form' => $form
        ));
    }


    /**
     * Edit a CourseInfoField entity
     *
     * @Route("/{id}/edit", name="edit", methods={"POST"})
     * @param EntityManagerInterface $entityManager
     * @param CourseInfoField $courseInfoField
     * @param Request $request
     * @return JsonResponse
     */
    public function editAction(EntityManagerInterface $entityManager, CourseInfoField $courseInfoField, Request $request)
    {
        $form = $this->createForm(CourseInfoFieldType::class, $courseInfoField);
        $form->handleRequest($request);


        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->flush();

            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false]);
    }
}
