<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Notification controller.
 *
 * @Route("/notification", name="app.admin.notification.")
 */
class NotificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $pagination = $this->get('knp_paginator')->paginate(
            $this->getDoctrine()->getManager()->createQuery("SELECT n FROM AppBundle:Notification n"),
            $request->query->getInt('page', 1),
            10
        );

        $deleteFormsView = [];

        foreach ($pagination as $group) {
            $deleteFormsView[$group->getId()] = $this->createDeleteForm($group)->createView();
        }

        return $this->render('notification/index.html.twig', array(
            'pagination' => $pagination,
            'deleteFormsView' => $deleteFormsView
        ));
    }

    /**
     * Creates a new notification entity.
     *
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $notification = new Notification();
        $form = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notification);
            $em->flush();

            $this->addFlash('success', 'La notification a été ajoutée avec succès');

            return $this->redirectToRoute('app.admin.notification.index');
        }

        return $this->render('notification/new.html.twig', array(
            'notification' => $notification,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notification entity.
     *
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Notification $notification)
    {
        $editForm = $this->createForm('AppBundle\Form\NotificationType', $notification);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La notification a été modifiée avec succès');

            return $this->redirectToRoute('app.admin.notification.edit', array('id' => $notification->getId()));
        }

        return $this->render('notification/edit.html.twig', array(
            'notification' => $notification,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a notification entity.
     *
     * @Route("/{id}", name="delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Notification $notification)
    {
        $form = $this->createDeleteForm($notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();

            $this->addFlash('success', 'La notification a été supprimée avec succès');
        }

        return $this->redirectToRoute('app.admin.notification.index');
    }

    /**
     * Creates a form to delete a notification entity.
     *
     * @param Notification $notification The notification entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Notification $notification)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app.admin.notification.delete', array('id' => $notification->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
