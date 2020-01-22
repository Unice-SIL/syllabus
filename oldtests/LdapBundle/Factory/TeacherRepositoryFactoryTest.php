<?php

namespace tests\LdapBundle\Factory;

use LdapBundle\Factory\TeacherRepositoryFactory;
use LdapBundle\Repository\TeacherRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class TeacherRepositoryFactoryTest
 * @package tests\LdapBundle\Factory
 */
class TeacherRepositoryFactoryTest extends WebTestCase
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
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
    }

    /**
     * @test
     */
    public function getService(){
        $teacherRepositoryFactory = new TeacherRepositoryFactory('teacher_inmemory_repository', $this->container);
        $service = $teacherRepositoryFactory->getService();
        $this->assertInstanceOf(TeacherRepositoryInterface::class, $service);
    }

    /**
     * @test
     */
    public function getServiceServiceNotFoundException(){
        $this->expectException(ServiceNotFoundException::class);
        $teacherRepositoryFactory = new TeacherRepositoryFactory('servicenotexist', $this->container);
        $service = $teacherRepositoryFactory->getService();
        $this->assertNull($service);
    }
}