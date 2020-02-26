<?php


namespace AppBundle\Manager;


use AppBundle\Entity\User;
use AppBundle\Helper\ErrorManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserManager extends AbstractManager
{
    private $tokenGenerator;

    /**
     * UserManager constructor.
     * @param TokenGeneratorInterface $tokenGenerator
     * @param EntityManagerInterface $em
     * @param ErrorManager $errorManager
     */
    public function __construct(
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $em,
        ErrorManager $errorManager
    )
    {
        parent::__construct($em, $errorManager);
        $this->tokenGenerator = $tokenGenerator;
    }

    public function create()
    {
        return new User();
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

    protected function getClass(): string
    {
        return User::class;
    }


}