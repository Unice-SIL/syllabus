<?php

namespace App\Syllabus\Subscriber;

use App\Syllabus\Entity\Notification;
use App\Syllabus\Helper\AppHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;

/**
 * Class NotificationSubscriber
 * @package App\Syllabus\Subscriber
 */
class NotificationSubscriber implements EventSubscriberInterface
{
    /**
     *
     */
    const NOTIFICATIONS_CACHE_KEY = 'app.notifications';
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var CsrfTokenManagerInterface
     */
    private CsrfTokenManagerInterface $csrfTokenManager;
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;

    /**
     * AdminNotificationSubscriber constructor.
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $em
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        RequestStack $requestStack,
        EntityManagerInterface $em,
        CsrfTokenManagerInterface $csrfTokenManager,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['setNotifications'],
            ],
        ];
    }

    /**
     * @param RequestEvent $event
     * @throws InvalidArgumentException
     */
    public function setNotifications(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $newAdminNotifications = [];
        $cache = new FilesystemAdapter();

        $notificationsCacheItem = $cache->getItem(self::NOTIFICATIONS_CACHE_KEY);

        if (!$notificationsCacheItem->isHit()) {

            $notificationsCacheItem->set($this->em->getRepository(Notification::class)->findBy([], ['updatedAt' => 'DESC']));
            $cache->save($notificationsCacheItem);
        }

        $adminNotifications = $notificationsCacheItem->get();


        if (is_array($adminNotifications)) {

            foreach ($adminNotifications as $notification) {

                //default configuration for a notification
                $newNotification = [
                    'id' => $notification->getId(),
                    'message' => $notification->getMessage(),
                    'token' => $this->csrfTokenManager->getToken('notification' . $notification->getId())->getValue(),
                    'path' => $this->urlGenerator->generate('app.notification.seen_one', ['id' => $notification->getId()])
                ];

                $oldAdminNotifications = $this->requestStack->getSession()->get('admin_notifications');

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

        $this->requestStack->getSession()->set( 'admin_notifications', $newAdminNotifications );
    }

}
