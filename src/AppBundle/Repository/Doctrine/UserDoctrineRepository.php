<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\User;
use AppBundle\Port\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class UserDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class UserDoctrineRepository implements UserRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * UserDoctrineRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find a user by id
     * @param string $id
     * @return User|null
     * @throws \Exception
     */
    public function find(string $id): ?User
    {
        $user = null;
        try{
            $user = $this->entityManager->getRepository(User::class)->find($id);
        }catch (\Exception $e){
            throw $e;
        }
        return $user;
    }

    /**
     * Find a user by username
     * @param string $username
     * @return User|null
     * @throws \Exception
     */
    public function findByUsername(string $username): ?User
    {
        $user = null;
        try {
            $user = $this->entityManager->getRepository(User::class)->findOneByUsername($username);
        }catch (\Exception $e){
            throw $e;
        }
        return $user;
    }

    /**
     * Create a user
     * @param User $user
     * @throws \Exception
     */
    public function create(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * Update a user
     * @param User $user
     * @throws \Exception
     */
    public function update(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }catch (\Exception $e){
            throw $e;
        }
    }
}