<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SyllabusDuplicationField;
use AppBundle\Form\SyllabusDuplicationFieldType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * SyllabusDuplicationField controller.
 *
 * @Route("/admin/syllabus-import-field", name="app_admin_syllabus_duplication_field_")
 */
class SyllabusDuplicationFieldController extends Controller
{
    /**
     * Lists all SyllabusDuplicationField entities.
     *
     * @Route("/", name="index")
     * @Method("GET")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {

        $form = $this->createForm(SyllabusDuplicationFieldType::class, null, ['method' => 'POST']);

        return $this->render('syllabus_duplication_field/index.html.twig', array(
            'syllabusDuplicationFields' => $em->getRepository(SyllabusDuplicationField::class)->findAll(),
            'form' => $form
        ));
    }


    /**
     * Edit a SyllabusDuplicationField entity
     *
     * @Route("/{id}/edit", name="edit")
     * @Method("POST")
     * @param EntityManagerInterface $entityManager
     * @param SyllabusDuplicationField $syllabusDuplicationField
     * @param Request $request
     */
    public function editAction(EntityManagerInterface $entityManager, SyllabusDuplicationField $syllabusDuplicationField, Request $request)
    {
        $form = $this->createForm(SyllabusDuplicationFieldType::class, $syllabusDuplicationField);
        $form->handleRequest($request);


        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->flush();

            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false]);
    }
}
