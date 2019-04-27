<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\Year;
use AppBundle\Repository\YearRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class YearDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class YearDoctrineRepository  extends AbstractDoctrineRepository implements YearRepositoryInterface
{

    /**
     * YearDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $id
     * @return Year|null
     * @throws \Exception
     */
    public function find(string $id): ?Year
    {
        $year = null;
        try{
            $year = $this->entityManager->getRepository(Year::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $year;
    }

    /**
     * @param Year $year
     * @throws \Exception
     */
    public function create(Year $year): void
    {
        try{
            $this->entityManager->persist($year);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param Year $year
     * @throws \Exception
     */
    public function update(Year $year): void
    {
        try{
            $this->entityManager->persist($year);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

}