<?php

namespace AppBundle\Security\Provider;


use AppBundle\Entity\User;
use AppBundle\Repository\Doctrine\UserDoctrineRepository;
use AppBundle\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use UniceSIL\ShibbolethBundle\Security\User\ShibbolethUserProviderInterface;

/**
 * Class ShibbolethUserProvider
 * @package AppBundle\Security\Provider
 */
class ShibbolethUserProvider implements ShibbolethUserProviderInterface
{

    /**
     * Default roles
     */
    const DEFAULT_ROLE = 'ROLE_USER';

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UserDoctrineRepository
     */
    private $userRepository;

    /**
     * ShibbolethUserProvider constructor.
     * @param RegistryInterface $registry
     * @param UserDoctrineRepository $userRepository
     */
    public function __construct(
        RegistryInterface $registry,
        UserDoctrineRepository $userRepository)
    {
        $this->em = $registry->getEntityManager();
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $credentials
     * @return User|object|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function loadUser(array $credentials)
    {
        if(!array_key_exists('username', $credentials)){
            throw new UsernameNotFoundException(sprintf("Username not found"));
        }

        $username = $credentials['username'];


        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
        if(!$user instanceof User)
        {
            $user = new User();
            $user->setUsername($username);
        }

        if(array_key_exists('givenName', $credentials)) {
            $user->setFirstname($credentials['givenName']);
        }else{
            $user->setFirstname("");
        }

        if(array_key_exists('sn', $credentials)) {
            $user->setLastname($credentials['sn']);
        }else{
            $user->setLastname("");
        }

        if(array_key_exists('mail', $credentials)) {
            $user->setEmail($credentials['mail']);
        }else{
            $user->setEmail("");
        }

        $roles = $user->getRoles();
        if(!in_array(self::DEFAULT_ROLE, $roles))
        {
            $roles[] = self::DEFAULT_ROLE;
        }
        $user->setRoles($roles);

        // On ne créé pas l'utilisateur en Bdd
        if(!empty($user->getId())){
            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }

    /**
     * @param string $username
     * @return User|object|UserInterface|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function loadUserByUsername($username)
    {
        return $this->loadUser(['username' => $username]);
    }

    /**
     * @param $username
     * @return User|null
     */
    public function refresh($username)
    {
        /** @var User|null $user */
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
        return $user;
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        $refreshedUser = $this->refresh($user->getUsername());
        return ($refreshedUser instanceof User)? $refreshedUser : $user;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}