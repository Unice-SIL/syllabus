<?php

namespace tests\LdapBundle\Repository\Doctrine;

use LdapBundle\Repository\InMemory\TeacherInMemoryRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CourseTeacherDoctrineRepositoryTest
 * @package tests\Repository\Doctrine
 */
class TeacherInMemoryRepositoryTest extends WebTestCase
{
    /**
     * @var TeacherInMemoryRepository
     */
    private $peopleInMemoryRepository;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->peopleInMemoryRepository = new TeacherInMemoryRepository();
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