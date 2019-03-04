<?php

namespace tests\LdapBundle\Repository\Doctrine;

use LdapBundle\Repository\InMemory\PeopleInMemoryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CourseTeacherDoctrineRepositoryTest
 * @package tests\Repository\Doctrine
 */
class PeopleInMemoryRepositoryTest extends WebTestCase
{
    /**
     * @var PeopleInMemoryRepository
     */
    private $peopleInMemoryRepository;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->peopleInMemoryRepository = new PeopleInMemoryRepository();
    }

    /**
     * @test
     */
    public function searchNoResult(){
        $peoples = $this->peopleInMemoryRepository->search('notfound');
        $this->assertCount(0, $peoples);
    }

    /**
     * @test
     */
    public function searchOneResult(){
        $peoples = $this->peopleInMemoryRepository->search('alexis');
        $this->assertCount(1, $peoples);
    }

    /**
     * @test
     */
    public function searchFourResults(){
        $peoples = $this->peopleInMemoryRepository->search('unice.fr');
        $this->assertCount(4, $peoples);
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->peopleInMemoryRepository);
    }
}