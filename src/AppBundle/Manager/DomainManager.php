<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Domain;
use AppBundle\Repository\DomainRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DomainManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var DomainRepositoryInterface
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, DomainRepositoryInterface $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function create()
    {
        return new Domain();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $domains = $this->repository->findAll();
        return $domains;
    }

}