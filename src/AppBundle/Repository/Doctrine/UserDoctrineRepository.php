<?php

namespace AppBundle\Repository\Doctrine;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserDoctrineRepository
 * @package AppBundle\Repository\Doctrine
 */
class UserDoctrineRepository implements UserRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserDoctrineRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
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

    /**
     * @param $query
     * @param array $searchFields
     * @return array
     */
    public function findLikeQuery($query, array $searchFields): array
    {
        $qb = $this->entityManager->getRepository(User::class)
            ->createQueryBuilder('u')
            ->setParameter('query', '%' . $query . '%')
            ;

        foreach ($searchFields as $field) {
            if (!in_array($field, ['u.firstname', 'u.lastname'])) {
                continue;
            }

            $qb->orWhere($field . ' LIKE :query');
        }

        return $qb->getQuery()->getResult();
    }
}