<?php

namespace App\Syllabus\Listener;

use App\Syllabus\Entity\Notification;
use App\Syllabus\Subscriber\NotificationSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Class CoursePresentationImageUploadListener
 * @package App\Syllabus\Listener
 */
class NotificationListener
{

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->deleteCacheNotification($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->deleteCacheNotification($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->deleteCacheNotification($args);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function deleteCacheNotification(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Notification) {
            return;
        }
        $cache = new FilesystemAdapter();
        $cache->deleteItem(NotificationSubscriber::NOTIFICATIONS_CACHE_KEY);
    }

}