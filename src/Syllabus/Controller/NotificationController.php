<?php

namespace App\Syllabus\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Notification controller.
 */
#[Route(path: '/notification', name: 'app.notification.')]
class NotificationController extends AbstractController
{

    #[Route(path: '/seen', name: 'seen', methods: ['POST'])]
    public function seenAction(Request $request): JsonResponse
    {
        if ($this->isCsrfTokenValid('notification-seen', $request->request->all('_token'))) {

            $session = $request->getSession();
            $adminNotifications = $session->get('admin_notifications');

            foreach ($adminNotifications as &$adminNotification) {
                $adminNotification['to_show'] = false;
            }

            $session->set('admin_notifications', $adminNotifications);

            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false]);
    }

    #[Route(path: '/seen/{id}', name: 'seen_one', methods: ['POST'])]
    public function seenOneAction(Request $request, string $id): JsonResponse
    {

        if ($this->isCsrfTokenValid('notification' . $id, $request->request->all('_token'))) {

            $session = $request->getSession();
            $adminNotifications = $session->get('admin_notifications');
            $adminNotifications[$id]['to_show'] = false;

            $session->set('admin_notifications', $adminNotifications);

            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false]);
    }

    #[Route(path: '/to-show', name: 'to_show', methods: ['GET'])]
    public function notificationToShowAction(RequestStack $requestStack): JsonResponse
    {

        $adminNotifications = $requestStack->getSession()->get('admin_notifications');

        if (!is_array($adminNotifications)) {
            $adminNotifications = [];
        }

        $notificationsToShow = array_filter($adminNotifications, function ($notification) { return $notification['to_show'];});

        return $this->json(['notificationsToShow' => $notificationsToShow]);
    }
}
