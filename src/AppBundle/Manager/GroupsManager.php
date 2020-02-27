<?php

namespace AppBundle\Manager;


use AppBundle\Entity\Groups;
use AppBundle\Repository\Doctrine\GroupsDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class GroupsManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var GroupsDoctrineRepository
     */
    private $repository;

    /**
     * GroupsManager constructor.
     * @param EntityManagerInterface $em
     * @param GroupsDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, GroupsDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Groups
     */
    public function new()
    {
        return new Groups();
    }

    /**
     * @param $id
     * @return Groups|null
     */
    public function find($id): ?Groups
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param Groups $groups
     */
    public function create(Groups $groups)
    {
        $this->em->persist($groups);
        $this->em->flush();
    }

    /**
     * @param Groups $groups
     */
    public function update(Groups $groups)
    {
        $this->em->flush();
    }

    /**
     * @param Groups $groups
     */
    public function delete(Groups $groups)
    {
        $this->em->remove($groups);
        $this->em->flush();
    }
}