<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Domain;
use AppBundle\Entity\Notification;
use AppBundle\Repository\Doctrine\DomainDoctrineRepository;
use AppBundle\Repository\Doctrine\NotificationDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class NotificationManager
 * @package AppBundle\Manager
 */
class NotificationManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var NotificationDoctrineRepository
     */
    private $repository;

    /**
     * DomainManager constructor.
     * @param EntityManagerInterface $em
     * @param NotificationDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, NotificationDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Notification
     */
    public function new()
    {
        return new Notification();
    }

    /**
     * @param $id
     * @return Notification|null
     */
    public function find($id): ?Notification
    {
        return $this->repository->find($id);
    }

    /**
     * @return array<Notification>
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Notification $notification
     */
    public function create(Notification $notification)
    {
        $this->em->persist($notification);
        $this->em->flush();
    }

    /**
     * @param Notification $notification
     */
    public function update(Notification $notification): void
    {
        $this->em->flush();
    }

    /**
     * @param Notification $notification
     */
    public function delete(Notification $notification): void
    {
        $this->em->remove($notification);
        $this->em->flush();
    }

}