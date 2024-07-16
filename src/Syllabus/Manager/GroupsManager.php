<?php

namespace App\Syllabus\Manager;


use App\Syllabus\Entity\Groups;
use App\Syllabus\Repository\Doctrine\GroupsDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class GroupsManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var GroupsDoctrineRepository
     */
    private GroupsDoctrineRepository $repository;

    /**
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
    public function new(): Groups
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
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Groups $groups
     */
    public function create(Groups $groups): void
    {
        $this->em->persist($groups);
        $this->em->flush();
    }

    /**
     * @param Groups $groups
     */
    public function update(Groups $groups): void
    {
        $this->em->flush();
    }

    /**
     * @param Groups $groups
     */
    public function delete(Groups $groups): void
    {
        $this->em->remove($groups);
        $this->em->flush();
    }
}