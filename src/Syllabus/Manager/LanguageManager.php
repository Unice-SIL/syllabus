<?php


namespace App\Syllabus\Manager;


use App\Syllabus\Entity\Language;
use App\Syllabus\Repository\Doctrine\LanguageDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class LanguageManager
 * @package App\Syllabus\Manager
 */
class LanguageManager
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var LanguageDoctrineRepository
     */
    private LanguageDoctrineRepository $repository;

    public function __construct(EntityManagerInterface $em, LanguageDoctrineRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @return Language
     */
    public function new(): Language
    {
        return new Language();
    }

    /**
     * @param string $id
     * @return Language|null
     * @throws \Exception
     */
    public function find(string $id): ?Language
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
     * @param Language $language
     */
    public function create(Language $language): void
    {
        $this->em->persist($language);
        $this->em->flush();
    }

    /**
     * @param Language $language
     */
    public function update(Language $language): void
    {
        $this->em->flush();
    }

    /**
     * @param Language $language
     */
    public function delete(Language $language): void
    {
        $this->em->remove($language);
        $this->em->flush();
    }

}