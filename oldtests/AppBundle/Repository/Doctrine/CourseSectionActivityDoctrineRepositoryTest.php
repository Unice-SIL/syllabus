<?php

namespace tests\AppBundle\Repository\Doctrine;

use AppBundle\Entity\CourseSectionActivity;
use AppBundle\Repository\Doctrine\CourseSectionActivityDoctrineRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CourseSectionActivityDoctrineRepositoryTest
 * @package tests\AppBundle\Repository\Doctrine
 */
class CourseSectionActivityDoctrineRepositoryTest extends WebTestCase
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
     * @var CourseSectionActivityDoctrineRepository
     */
    private $courseSectionActivityDoctrineRepository;

    /**
     * @var string
     */
    private static $coursesectionactivityid;

    /**
     * @var CourseSectionActivity
     */
    private $courseSectionActivity;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager('syllabus');
        $this->courseSectionActivityDoctrineRepository = new CourseSectionActivityDoctrineRepository($this->em);

        if(is_null(self::$application)){
            self::$application = new Application($this->client->getKernel());
            self::$application->setAutoExit(false);
            self::$application->run(new StringInput("doctrine:database:drop --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:database:create --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:schema:update --force --env=test --quiet"));
            self::$application->run(new StringInput("doctrine:fixtures:load --env=test --quiet"));

            $courseSectionActivities = $this->em->getRepository(CourseSectionActivity::class)->findAll();
            if(count($courseSectionActivities) > 0) {
                $this->courseSectionActivity = $courseSectionActivities[0];
                self::$coursesectionactivityid = $this->courseSectionActivity->getId();
            }
        }

        $this->courseSectionActivity = $this->em->getRepository(CourseSectionActivity::class)->find(self::$coursesectionactivityid);
    }

    /**
     * @test
     */
    public function findSuccessful(){
        $courseSectionActivity = $this->courseSectionActivityDoctrineRepository->find($this->courseSectionActivity->getId());
        $this->assertEquals($this->courseSectionActivity, $courseSectionActivity);
    }

    /**
     * @test
     */
    public function findCourseSectionNotFound(){
        $courseSectionActivity = $this->courseSectionActivityDoctrineRepository->find('fakeid');
        $this->assertNull($courseSectionActivity);
    }

    /**
     * @test
     */
    public function deleteSuccessful(){
        $this->courseSectionActivityDoctrineRepository->delete($this->courseSectionActivity);
        $courseSectionActivity = $this->courseSectionActivityDoctrineRepository->find($this->courseSectionActivity->getId());
        $this->assertNull($courseSectionActivity);
        $this->courseSectionActivityDoctrineRepository->create($this->courseSectionActivity);
        $courseSectionActivity = $this->courseSectionActivityDoctrineRepository->find($this->courseSectionActivity->getId());
        $this->assertEquals($this->courseSectionActivity, $courseSectionActivity);
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