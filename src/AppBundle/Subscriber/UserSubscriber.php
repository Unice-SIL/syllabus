<?php


namespace AppBundle\Subscriber;

use AppBundle\Entity\User;
use AppBundle\Helper\MailHelper;
use AppBundle\Manager\UserManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class UserSubscriber implements EventSubscriber
{
    /**
     * @var UserManager
     */
    private $mailer;
    /**
     * @var UserManager
     */
    private $userManager;


    /**
     * UserSubscriber constructor.
     */
    public function __construct(MailHelper $mailer, UserManager $userManager)
    {
        $this->mailer = $mailer;
        $this->userManager = $userManager;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        /** @var User|null $user */
        if (!$user = $this->getUserOrNull($args->getObject())) {
            return;
        }

        $this->resetPasswordProcess($user);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var User|null $user */
        if (!$user = $this->getUserOrNull($args->getObject())) {
            return;
        }

        $this->resetPasswordProcess($user);

    }

    private function getUserOrNull($entity)
    {
        if (!$entity instanceof User) {
            return null;
        }

        return $entity;
    }

    private function resetPasswordProcess(User $user)
    {
        if (!$user->hasRole('ROLE_API') or null !== $user->getPassword())
        {
            return;
        }

        $token = $this->userManager->setResetPasswordToken($user);

        $this->mailer->sendResetPasswordMessage($user, $token);
    }
}
