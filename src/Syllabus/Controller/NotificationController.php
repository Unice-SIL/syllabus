<?php

namespace App\Syllabus\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Notification controller.
 *
 * @Route("/notification", name="app.notification.")
 */
class NotificationController extends AbstractController
{

    /**
     * @Route("/seen", name="seen", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function seenAction(Request $request)
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

    /**
     * @Route("/seen/{id}", name="seen_one", methods={"POST"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function seenOneAction(Request $request, string $id)
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

    /**
     * @Route("/to-show", name="to_show", methods={"GET"})
     * @param RequestStack $requestStack
     * @return JsonResponse
     */
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
