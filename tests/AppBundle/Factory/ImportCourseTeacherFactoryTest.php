<?php

namespace tests\AppBundle\Factory;

use AppBundle\Factory\ImportCourseTeacherFactory;
use AppBundle\Query\CourseTeacher\Adapter\ImportCourseTeacherQueryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Class ImportCourseTeacherFactoryTest
 * @package tests\AppBundle\Factory
 */
class ImportCourseTeacherFactoryTest extends KernelTestCase
{
    /**
     * @var
     */
    private $container;

    /**
     * @var array
     */
    private $courseTeacherFactoryParams = [];

    /**
     *
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();

        $this->courseTeacherFactoryParams['sources'] = [
            'ldap' => [
                'name' => 'LDAP',
                'service' => 'AppBundle\Query\CourseTeacher\Adapter\Ldap\ImportCourseTeacherLdapQuery',
            ],
            'servicenotset' => [],
        ];
    }

    /**
     * @test
     */
    public function getQuerySuccessful(){
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getQuery('ldap');
        $this->assertInstanceOf(ImportCourseTeacherQueryInterface::class, $importCourseTeacherQuery);
    }

    /**
     * @test
     */
    public function getQuerySourcesNotFoundException(){
        $this->expectException(\Exception::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory([], $this->container);
        $this->assertNull($importCourseTeacherFactory);
    }

    /**
     * @test
     */
    public function getQuerySourcesIsNotArrayException(){
        $this->expectException(\Exception::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory(['sources' => null], $this->container);
        $this->assertNull($importCourseTeacherFactory);
    }

    /**
     * @test
     */
    public function getQuerySourceNotFoundException(){
        $this->expectException(\Exception::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getQuery('servicenotfound');
        $this->assertNull($importCourseTeacherQuery);
    }

    /**
     * @test
     */
    public function getQuerySourceNotSetException(){
        $this->expectException(ServiceNotFoundException::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getQuery('servicenotset');
        $this->assertNull($importCourseTeacherQuery);
    }
}