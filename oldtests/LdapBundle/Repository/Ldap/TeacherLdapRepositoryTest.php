<?php

namespace tests\LdapBundle\Repository\Ldap;

use LdapBundle\Collection\TeacherCollection;
use LdapBundle\Entity\Teacher;
use LdapBundle\Repository\Ldap\TeacherLdapRepository;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Ldap\Ldap;

/**
 * Class TeacherLdapRepositoryTest
 * @package tests\LdapBundle\Repository\Ldap
 */
class TeacherLdapRepositoryTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TeacherLdapRepository
     */
    private $teacherLdapRepository;

    /**
     *
     */
    public function setUp(){
        parent::setUp();
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->teacherLdapRepository = $this->container->get('teacher_ldap_repository');
    }

    /**
     * @test
     */
    public function find(){
        $teacher = $this->teacherLdapRepository->find('casazza');
        $this->assertInstanceOf(Teacher::class, $teacher);
    }

    /**
     * @test
     */
    public function notFound(){
        $teacher = $this->teacherLdapRepository->find('abcdefghijk123');
        $this->assertNull($teacher);
    }

    /**
     * @test
     */
    public function search(){
        $teachers = $this->teacherLdapRepository->search('casa');
        $this->assertInstanceOf(TeacherCollection::class, $teachers);
        $this->assertGreaterThan(0, $teachers->count());
    }

    /**
     * @test
     */
    public function searchNull(){
        $teachers = $this->teacherLdapRepository->search('abcdefghijk123');
        $this->assertInstanceOf(TeacherCollection::class, $teachers);
        $this->assertCount(0, $teachers);
    }

}