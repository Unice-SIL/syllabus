<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Level;
use AppBundle\Repository\Doctrine\LevelDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LevelManager
 * @package AppBundle\Manager
 */
class LevelManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var LevelDoctrineRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em, LevelDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Level
     */
    public function new()
    {
        return new Level();
    }

    /**
     * @param string $id
     * @return Level|null
     * @throws \Exception
     */
    public function find($id): ?Level
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Level $language
     */
    public function create(Level $language): void
    {
        $this->em->persist($language);
        $this->em->flush();
    }

    /**
     * @param Level $language
     */
    public function update(Level $language): void
    {
        $this->em->flush();
    }

    /**
     * @param Level $language
     */
    public function delete(Level $language): void
    {
        $this->em->remove($language);
        $this->em->flush();
    }

}