<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Year;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use AppBundle\Repository\YearRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class YearManager
{

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $repository;


    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->repository = $em->getRepository(Year::class);
    }


    public function create()
    {
        return new Year();
    }

    public function update(Year $year)
    {
        //Set current property to false for the others years
        if ($year->getCurrent()) {
            $currentYears = $this->repository->findByCurrent(true);

            foreach ($currentYears as $currentYear) {
                $currentYear->setCurrent(false);
            }
        }

        return true;
    }
}