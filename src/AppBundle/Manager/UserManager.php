<?php


namespace AppBundle\Manager;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserManager
{
    private $tokenGenerator;
    private $em;

    /**
     * UserManager constructor.
     * @param TokenGeneratorInterface $tokenGenerator
     * @param EntityManagerInterface $em
     */
    public function __construct(TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $em)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->em = $em;
    }

    public function create()
    {
        $user = new User();
        return $user;
    }

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
}