<?php


namespace App\Syllabus\Manager;


use App\Syllabus\Entity\AskAdvice;
use App\Syllabus\Repository\Doctrine\AskAdviceDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class AskAdviceManager
{
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $em;

    /**
     * @var AskAdviceDoctrineRepository
     */
    private $repository;

    /**
     * ActivityManager constructor.
     * @param EntityManagerInterface $em
     * @param AskAdviceDoctrineRepository $repository
     */
    public function __construct(EntityManagerInterface $em, AskAdviceDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return AskAdvice
     */
    public function new()
    {
        return new AskAdvice();
    }

    /**
     * @param $id
     * @return AskAdvice|null
     */
    public function find($id): ?AskAdvice
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param AskAdvice $advice
     */
    public function create(AskAdvice $advice)
    {
        $this->em->persist($advice);
        $this->em->flush();
    }

    /**
     * @param AskAdvice $advice
     */
    public function update(AskAdvice $advice)
    {
        $this->em->flush();
    }

    /**
     * @param AskAdvice $advice
     */
    public function delete(AskAdvice $advice)
    {
        $this->em->remove($advice);
        $this->em->flush();
    }
}