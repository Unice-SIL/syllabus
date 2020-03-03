<?php

namespace AppBundle\Subscirber;

use AppBundle\Helper\AppHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AdminNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var SessionInterface
     */
    private $session;
    private $adminNotifications;

    /**
     * AdminNotificationSubscriber constructor.
     * @param SessionInterface $session
     * @param array $adminNotifications
     */
    public function __construct(SessionInterface $session, $adminNotifications)
    {
        $this->session = $session;
        $this->adminNotifications = $adminNotifications;
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
        if (is_array($this->adminNotifications)) {

            foreach ($this->adminNotifications as $notification) {

                //id and message are mandatory
                if (!isset($notification['id']) or !isset($notification['message'])) {
                    continue;
                }

                //default configuration for a notification
                $newNotification = [
                    'id' => $notification['id'],
                    'message' => $notification['message'],
                    'type' => $notification['type'] ?? null,
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


                $newAdminNotifications[$notification['id']] = $newNotification;
            }
        }

        $this->session->set( 'admin_notifications', $newAdminNotifications );
    }

}
