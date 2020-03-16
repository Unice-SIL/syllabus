<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Notification;
use AppBundle\Subscirber\NotificationSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Class CoursePresentationImageUploadListener
 * @package AppBundle\Listener
 */
class NotificationListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->deleteCacheNotification($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->deleteCacheNotification($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->deleteCacheNotification($args);
    }

    private function deleteCacheNotification(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Notification) {
            return;
        }
        $cache = new FilesystemAdapter();
        $cache->deleteItem(NotificationSubscriber::NOTIFICATIONS_CACHE_KEY);
    }

}