<?php

namespace tests\Repository\Doctrine;

use AppBundle\Entity\User;
use AppBundle\Repository\Doctrine\UserDoctrineRepository;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserDoctrineRepository
 * @package tests\Repository\Doctrine
 */
class UserDoctrineRepositoryTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ContainerInterface|null
     */
    private $container;

    /**
     * @var Application|null
     */
    private static $application = null;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UserDoctrineRepository
     */
    private $userDoctrineRepository;

    /**
     * @var User
     */
    private static $userid;

    /**
     * @var User
     */
    private $user;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager('syllabus');
        $this->userDoctrineRepository = new UserDoctrineRepository($this->em);

        if(is_null(self::$application)){
            self::$application = new Application($this->client->getKernel());
            self::$application->setAutoExit(false);
            self::$application->run(new StringInput("doctrine:database:drop --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:database:create --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:schema:update --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:fixtures:load --env=test --quiet"));

            $users = $this->em->getRepository(User::class)->findAll();
            if(count($users) > 0) {
                $this->user = $users[0];
                self::$userid = $this->user->getId();
            }
        }

        $this->user = $this->em->getRepository(User::class)->find(self::$userid);
    }

    /**
     * @test
     */
    public function findSuccessful(){
        $user = $this->userDoctrineRepository->find($this->user->getId());
        $this->assertEquals($this->user, $user);
    }

    /**
     * @test
     */
    public function findUserNotFound(){
        $user = $this->userDoctrineRepository->find('fakeid');
        $this->assertNull($user);
    }

    /**
     * @test
     */
    public function findByUsernameSuccessful(){
        $user = $this->userDoctrineRepository->findByUsername($this->user->getUsername());
        $this->assertEquals($this->user, $user);
    }

    /**
     * @test
     */
    public function findByUsernameUserNotFound(){
        $user = $this->userDoctrineRepository->findByUsername('fakeusername');
        $this->assertNull($user);
    }

    /**
     * @test
     */
    public function createSuccessful(){
        $user = clone $this->user;
        $user->setId(Uuid::uuid4())
            ->setUsername('newuser');
        $this->userDoctrineRepository->create($user);
        $userCreated = $this->userDoctrineRepository->find($user->getId());
        $this->assertEquals($user, $userCreated);
    }

    /**
     * @test
     */
    public function createException(){
        $this->expectException(\Exception::class);
        $this->userDoctrineRepository->create(new User());
    }

    /**
     * @test
     */
    public function updateSuccessful(){
        $user = $this->user;
        $user->setFirstname('updateFirstname');
        $this->userDoctrineRepository->update($user);
        $userUpdated = $this->userDoctrineRepository->find($user->getId());
        $this->assertEquals($user, $userUpdated);
    }

    /**
     * @test
     */
    public function updateException(){
        $this->expectException(\Exception::class);
        $user = $this->user;
        $user->setId('');
        $this->userDoctrineRepository->update($user);
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->client);
        unset($this->container);
        unset($this->em);
        unset($this->userDoctrineRepository);
        unset($this->user);
    }
}