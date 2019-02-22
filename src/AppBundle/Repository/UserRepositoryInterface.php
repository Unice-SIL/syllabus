<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package AppBundle\Repository
 */
interface UserRepositoryInterface
{
    /**
     * Find a user by id
     * @param string $id
     * @return User|null
     */
    public function find(string $id): ?User;

    /**
     * Find a user by username
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): ?User;

    /**
     * Create a user
     * @param User $user
     * @return mixed
     */
    public function create(User $user): void;

    /**
     * Update a user
     * @param User $user
     * @return mixed
     */
    public function update(User $user): void;
}