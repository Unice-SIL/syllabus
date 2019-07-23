<?php

namespace AppBundle\Query\Year;

use AppBundle\Exception\YearNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\YearRepositoryInterface;

/**
 * Class FindYearById
 * @package AppBundle\Query\Year
 */
class FindYearById implements QueryInterface
{
    /**
     * @var YearRepositoryInterface
     */
    private $yearRepository;

    private $id;

    /**
     * FindYearById constructor.
     * @param YearRepositoryInterface $yearRepository
     */
    public function __construct(
        YearRepositoryInterface $yearRepository
    )
    {
        $this->yearRepository = $yearRepository;
    }

    /**
     * @param mixed $id
     * @return FindYearById
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\Year|null
     * @throws \Exception
     */
    public function execute()
    {
        try{
            $year = $this->yearRepository->find($this->id);
            if(is_null($year))
            {
                throw new YearNotFoundException();
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $year;
    }
}