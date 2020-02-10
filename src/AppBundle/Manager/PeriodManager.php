<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Period;
use AppBundle\Repository\PeriodRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class PeriodManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var PeriodRepositoryInterface
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, PeriodRepositoryInterface $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function create()
    {
        return new Period();
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