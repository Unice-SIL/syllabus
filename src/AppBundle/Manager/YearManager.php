<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Year;
use Doctrine\ORM\EntityManagerInterface;

class YearManager
{


    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->repository = $em->getRepository(Year::class);
    }


    public function create()
    {
        $year = new Year();

        return $year;
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