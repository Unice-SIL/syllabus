<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CourseInfoField;
use AppBundle\Form\CourseInfoFieldType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * CourseInfoField controller.
 *
 * @Route("/admin/syllabus-import-field", name="app_admin_course_info_field_")
 */
class CourseInfoFieldController extends Controller
{
    /**
     * Lists all CourseInfoField entities.
     * @Route("/", name="index")
     *
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @Route("/{id}/edit", name="edit")
     * @Method("POST")
     * @param EntityManagerInterface $entityManager
     * @param CourseInfoField $courseInfoField
     * @param Request $request
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
