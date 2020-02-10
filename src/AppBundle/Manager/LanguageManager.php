<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Language;
use AppBundle\Repository\LanguageRepositoryInterface;
use AppBundle\Repository\PeriodRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class LanguageManager
{
    /**
     * @var ObjectRepository
     */
    private $em;

    /**
     * @var PeriodRepositoryInterface
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, LanguageRepositoryInterface $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function create()
    {
        return new Language();
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