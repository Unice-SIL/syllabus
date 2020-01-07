<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("/admin/user", name="app_admin_user_")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $pagination = $this->get('knp_paginator')->paginate(
            $this->getDoctrine()->getManager()->createQuery("SELECT u FROM AppBundle:User u"),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('user/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Displays a form to edit an existing year entity.
     *
     * Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    /*public function editAction(Request $request, Year $year)
    {
        $editForm = $this->createForm('AppBundle\Form\YearType', $year);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_admin_year_edit', array('id' => $year->getId()));
        }

        return $this->render('year/edit.html.twig', array(
            'year' => $year,
            'edit_form' => $editForm->createView(),
        ));
    }*/
}
