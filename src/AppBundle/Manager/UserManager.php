<?php

namespace AppBundle\Manager;

use AppBundle\Entity\User;
use AppBundle\Helper\ErrorManager;
use AppBundle\Repository\Doctrine\UserDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserManager extends AbstractManager
{
    /**
     * @var UserDoctrineRepository
     */
    private $repository;

    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    /**
     * UserManager constructor.
     * @param TokenGeneratorInterface $tokenGenerator
     * @param EntityManagerInterface $em
     * @param ErrorManager $errorManager
     * @param UserDoctrineRepository $repository
     */
    public function __construct(
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $em,
        ErrorManager $errorManager,
        UserDoctrineRepository $repository
    )
    {
        parent::__construct($em, $errorManager);
        $this->tokenGenerator = $tokenGenerator;
        $this->repository = $repository;
    }

    public function new()
    {
        return new User();
    }


    /**
     * @param string $id
     * @return User|null
     */
    public function find(string $id): ?User
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): ?User
    {
        return $this->repository->findOneBy($username);
    }

    /**
     * @param User $user
     */
    public function create(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function update(User $user): void
    {
        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @param array $options
     * @return string
     */
    public function setResetPasswordToken(User $user, array $options = [])
    {
        $options = array_merge($defaultOptions = [
            'flush' => false,
        ], $options);

        $token = $this->tokenGenerator->generateToken();
        $user->setResetPasswordToken($token);

        if (true === $options['flush']) {
            $this->em->flush();
        }

        return $token;
    }

    /**
     * @return string
     */
    protected function getClass(): string
    {
        return User::class;
    }


}