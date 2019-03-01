<?php

namespace tests\AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseTeacher;
use AppBundle\Repository\Doctrine\CourseTeacherDoctrineRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CourseTeacherDoctrineRepositoryTest
 * @package tests\Repository\Doctrine
 */
class CourseTeacherDoctrineRepositoryTest extends WebTestCase
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
     * @var CourseTeacherDoctrineRepository
     */
    private $courseTeacherDoctrineRepository;

    /**
     * @var string
     */
    private static $courseteacherid;

    /**
     * @var CourseTeacher
     */
    private $courseTeacher;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager('syllabus');
        $this->courseTeacherDoctrineRepository = new CourseTeacherDoctrineRepository($this->em);

        if(is_null(self::$application)){
            self::$application = new Application($this->client->getKernel());
            self::$application->setAutoExit(false);
            self::$application->run(new StringInput("doctrine:database:drop --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:database:create --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:schema:update --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:fixtures:load --env=test --quiet"));

            $courseTeachers = $this->em->getRepository(CourseTeacher::class)->findAll();
            if(count($courseTeachers) > 0) {
                $this->courseTeacher = $courseTeachers[0];
                self::$courseteacherid = $this->courseTeacher->getId();
            }
        }

        $this->courseTeacher = $this->em->getRepository(CourseTeacher::class)->find(self::$courseteacherid);
    }

    /**
     * @test
     */
    public function findSuccessful(){
        $courseTeacher = $this->courseTeacherDoctrineRepository->find($this->courseTeacher->getId());
        $this->assertEquals($this->courseTeacher, $courseTeacher);
    }

    /**
     * @test
     */
    public function findCourseTeacherNotFound(){
        $courseTeacher = $this->courseTeacherDoctrineRepository->find('fakeid');
        $this->assertNull($courseTeacher);
    }

    /**
     * @test
     */
    public function deleteSuccessful(){
        $this->courseTeacherDoctrineRepository->delete($this->courseTeacher);
        $courseTeacher = $this->courseTeacherDoctrineRepository->find($this->courseTeacher->getId());
        $this->assertNull($courseTeacher);
        $this->courseTeacherDoctrineRepository->create($this->courseTeacher);
        $courseTeacher = $this->courseTeacherDoctrineRepository->find($this->courseTeacher->getId());
        $this->assertEquals($this->courseTeacher, $courseTeacher);
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