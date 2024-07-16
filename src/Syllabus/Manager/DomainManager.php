<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\Domain;
use App\Syllabus\Repository\Doctrine\DomainDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DomainManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var DomainDoctrineRepository
     */
    private DomainDoctrineRepository $repository;

    /**
     * DomainManager constructor.
     * @param EntityManagerInterface $em
     * @param DomainDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, DomainDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Domain
     */
    public function new(): Domain
    {
        return new Domain();
    }

    /**
     * @param $id
     * @return Domain|null
     */
    public function find($id): ?Domain
    {
        return $this->repository->find($id);
    }

    /**
     * @return array|object[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Domain $domain
     */
    public function create(Domain $domain): void
    {
        $this->em->persist($domain);
        $this->em->flush();
    }

    /**
     * @param Domain $domain
     */
    public function update(Domain $domain): void
    {
        $this->em->flush();
    }

    /**
     * @param Domain $domain
     */
    public function delete(Domain $domain): void
    {
        $this->em->remove($domain);
        $this->em->flush();
    }

}