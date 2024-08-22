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
 * @Security("is_granted('ROLE_ADMIN_NOTIFICATION')")
 */
#[Route(path: 'admin/notification', name: 'app.admin.notification.')]
class NotificationController extends AbstractController
{
    /**
     * Lists all notification entities.
     *
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_LIST')")
     *
     */
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function indexAction(
        Request $request,
        NotificationDoctrineRepository $repository,
        PaginatorInterface $paginator
    ): Response
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
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_CREATE')")
     *
     */
    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function newAction(Request $request, NotificationManager $notificationManager, TranslatorInterface $translator): RedirectResponse|Response
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
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_UPDATE')")
     *
     */
    #[Route(path: '/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Notification $notification, NotificationManager $notificationManager, TranslatorInterface $translator): RedirectResponse|Response
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
     * @Security("is_granted('ROLE_ADMIN_NOTIFICATION_DELETE')")
     *
     */
    #[Route(path: '/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteAction(Request $request, Notification $notification, NotificationManager $notificationManager, TranslatorInterface $translator): RedirectResponse
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
    private function createDeleteForm(Notification $notification): FormInterface
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('app.admin.notification.delete', array('id' => $notification->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
