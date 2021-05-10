<?php

namespace App\Syllabus\Controller\Admin;

use App\Syllabus\Entity\Notification;
use App\Syllabus\Form\NotificationType;
use App\Syllabus\Manager\NotificationManager;
use App\Syllabus\Repository\Doctrine\NotificationDoctrineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Notification controller.
 *
 * @Route("admin/notification", name="app.admin.notification.")
 * @Security("is_granted('ROLE_ADMIN_NOTIFICATION')")
 */
class NotificationController extends AbstractController
{
    /**
     * Lists all notification entities.
     *
     * @Route("/", name="index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_LIST')")
     *
     * @param Request $request
     * @param NotificationDoctrineRepository $repository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexAction(
        Request $request,
        NotificationDoctrineRepository $repository,
        PaginatorInterface $paginator
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
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_CREATE')")
     *
     * @param Request $request
     * @param NotificationManager $notificationManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request, NotificationManager $notificationManager, TranslatorInterface $translator)
    {
        $notification = $notificationManager->new();
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationManager->create($notification);

            $this->addFlash('success', $translator->trans('admin.notification.flashbag.new'));

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
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_UPDATE')")
     *
     * @param Request $request
     * @param Notification $notification
     * @param NotificationManager $notificationManager
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Notification $notification, NotificationManager $notificationManager, TranslatorInterface $translator)
    {
        $editForm = $this->createForm(NotificationType::class, $notification);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $notificationManager->update($notification);

            $this->addFlash('success', $translator->trans('admin.notification.flashbag.edit'));

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
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_DELETE')")
     *
     * @param Request $request
     * @param Notification $notification
     * @param NotificationManager $notificationManager
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Notification $notification, NotificationManager $notificationManager, TranslatorInterface $translator)
    {
        $form = $this->createDeleteForm($notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationManager->delete($notification);

            $this->addFlash('success', $translator->trans('admin.notification.flashbag.delete'));
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
