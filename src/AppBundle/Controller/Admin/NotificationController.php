<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Notification;
use AppBundle\Form\Filter\CourseInfoFilterType;
use AppBundle\Form\NotificationType;
use AppBundle\Manager\NotificationManager;
use AppBundle\Repository\Doctrine\NotificationDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Notification controller.
 *
 * @Route("admin/notification", name="app.admin.notification.")
 * @Security("has_role('ROLE_ADMIN_NOTIFICATION')")
 */
class NotificationController extends AbstractController
{
    /**
     * Lists all notification entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN_NOTIFICATION_LIST')")
     *
     * @param Request $request
     * @param NotificationDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @return Response
     */
    public function indexAction(
        Request $request,
        NotificationDoctrineRepository $repository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $filterBuilderUpdater
    )
    {
        $qb =  $repository->getIndexQueryBuilder();

        $pagination = $paginator->paginate(
            $qb,
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
     * @Route("/new", name="new", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_NOTIFICATION_CREATE')")
     *
     * @param Request $request
     * @param NotificationManager $notificationManager
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, NotificationManager $notificationManager)
    {
        $notification = $notificationManager->new();
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationManager->create($notification);

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
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_NOTIFICATION_UPDATE')")
     *
     * @param Request $request
     * @param Notification $notification
     * @param NotificationManager $notificationManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Notification $notification, NotificationManager $notificationManager)
    {
        $editForm = $this->createForm(NotificationType::class, $notification);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $notificationManager->update($notification);

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
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @Security("has_role('ROLE_ADMIN_NOTIFICATION_DELETE')")
     *
     * @param Request $request
     * @param Notification $notification
     * @param NotificationManager $notificationManager
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Notification $notification, NotificationManager $notificationManager)
    {
        $form = $this->createDeleteForm($notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationManager->delete($notification);

            $this->addFlash('success', 'La notification a été supprimée avec succès');
        }

        return $this->redirectToRoute('app.admin.notification.index');
    }

    /**
     * Creates a form to delete a notification entity.
     *
     * @param Notification $notification The notification entity
     *
     * @return FormInterface The form
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
