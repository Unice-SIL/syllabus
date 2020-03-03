<?php


namespace AppBundle\Controller;


use phpDocumentor\Reflection\Types\String_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class NotificationController
 * @package AppBundle\Controller
 * @Route("/notification", name="app.notification.")
 */
class NotificationController extends AbstractController
{

    /**
     * @Route("/seen/{id}", name="seen", methods={"POST"})
     * @param SessionInterface $session
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function seenAction(Request $request, string $id)
    {

        if ($this->isCsrfTokenValid('notification' . $id, $request->request->get('_token'))) {

            $session = $request->getSession();
            $adminNotifications = $session->get('admin_notifications');
            $adminNotifications[$id]['to_show'] = false;

            $session->set('admin_notifications', $adminNotifications);

            $notificationsToShow = array_filter($adminNotifications, function ($notification) {return $notification['to_show'];});

            return $this->json(['success' => true,'count' => count($notificationsToShow)]);
        }

        return $this->json(['success' => false]);
    }
}