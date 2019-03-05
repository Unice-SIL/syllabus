<?php

namespace tests\AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseSection;
use AppBundle\Repository\Doctrine\CourseSectionDoctrineRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CourseSectionDoctrineRepositoryTest
 * @package tests\AppBundle\Repository\Doctrine
 */
class CourseSectionDoctrineRepositoryTest extends WebTestCase
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
     * @var CourseSectionDoctrineRepository
     */
    private $courseSectionDoctrineRepository;

    /**
     * @var string
     */
    private static $coursesectionid;

    /**
     * @var CourseSection
     */
    private $courseSection;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager('syllabus');
        $this->courseSectionDoctrineRepository = new CourseSectionDoctrineRepository($this->em);

        if(is_null(self::$application)){
            self::$application = new Application($this->client->getKernel());
            self::$application->setAutoExit(false);
            self::$application->run(new StringInput("doctrine:database:drop --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:database:create --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:schema:update --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:fixtures:load --env=test --quiet"));

            $courseSection = $this->em->getRepository(CourseSection::class)->findAll();
            if(count($courseSection) > 0) {
                $this->courseSection = $courseSection[0];
                self::$coursesectionid = $this->courseSection->getId();
            }
        }

        $this->courseSection = $this->em->getRepository(CourseSection::class)->find(self::$coursesectionid);
    }

    /**
     * @test
     */
    public function findSuccessful(){
        $courseSection = $this->courseSectionDoctrineRepository->find($this->courseSection->getId());
        $this->assertEquals($this->courseSection, $courseSection);
    }

    /**
     * @test
     */
    public function findCourseSectionNotFound(){
        $courseSection = $this->courseSectionDoctrineRepository->find('fakeid');
        $this->assertNull($courseSection);
    }

    /**
     * @test
     */
    public function deleteSuccessful(){
        $this->courseSectionDoctrineRepository->delete($this->courseSection);
        $courseSection = $this->courseSectionDoctrineRepository->find($this->courseSection->getId());
        $this->assertNull($courseSection);
        $this->courseSectionDoctrineRepository->create($this->courseSection);
        $courseSection = $this->courseSectionDoctrineRepository->find($this->courseSection->getId());
        $this->assertEquals($this->courseSection, $courseSection);
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