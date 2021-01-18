<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\Domain;
use App\Syllabus\Repository\Doctrine\DomainDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DomainManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var DomainDoctrineRepository
     */
    private $repository;

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
    public function new()
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
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param Domain $domain
     */
    public function create(Domain $domain)
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