<?php

namespace AppBundle\Subscirber;

use AppBundle\Entity\Notification;
use AppBundle\Helper\AppHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;

class NotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UriSafeTokenGenerator
     */
    private $csrfTokenManager;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * AdminNotificationSubscriber constructor.
     * @param SessionInterface $session
     * @param EntityManagerInterface $em
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $em,
        CsrfTokenManagerInterface $csrfTokenManager,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->session = $session;
        $this->em = $em;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::REQUEST => [
                ['setNotifications'],
            ],
        ];
    }

    public function setNotifications(GetResponseEvent $event)
    {
        $newAdminNotifications = [];
        $adminNotifications = $this->em->getRepository(Notification::class)->findBy([], ['updatedAt' => 'DESC']);

        if (is_array($adminNotifications)) {

            foreach ($adminNotifications as $notification) {

                //default configuration for a notification
                $newNotification = [
                    'id' => $notification->getId(),
                    'message' => $notification->getMessage(),
                    'token' => $this->csrfTokenManager->getToken('notification' . $notification->getId())->getValue(),
                    'path' => $this->urlGenerator->generate('app.notification.seen_one', ['id' => $notification->getId()])
                ];

                $oldAdminNotifications = $this->session->get('admin_notifications');

                if (isset($oldAdminNotifications[$newNotification['id']])) {

                    //We stock old data
                    $oldNotification = $oldAdminNotifications[$newNotification['id']];
                    $oldToshow = $oldNotification['to_show'];
                    //unset "to_show" index to compare arrays on every values except the one with "to_show" index
                    unset($oldNotification['to_show']);
                    if (AppHelper::sameArrays($newNotification, $oldNotification)) {
                        //If the notification was not changed, we keep the to_show value
                        $newNotification['to_show'] = $oldToshow;
                    } else {
                        //If the notification has a change (e.g. new message, new type ...) we set "to_show" to true
                        $newNotification['to_show'] = true;
                    }
                } else {
                    //Default "to_show" value if the notification was not in session yet
                    $newNotification['to_show'] = true;
                }

                $newAdminNotifications[$newNotification['id']] = $newNotification;
            }
        }

        $this->session->set( 'admin_notifications', $newAdminNotifications );
    }

}
