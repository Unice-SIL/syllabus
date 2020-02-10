<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Campus;
use AppBundle\Repository\CampusRepositoryinterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class CampusManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var CampusRepositoryInterface
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, CampusRepositoryInterface $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function create()
    {
        return new Campus();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $period = $this->repository->findAll();
        return $period;
    }
}