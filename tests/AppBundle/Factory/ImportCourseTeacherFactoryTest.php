<?php

namespace tests\AppBundle\Factory;

use AppBundle\Factory\ImportCourseTeacherFactory;
use AppBundle\Query\CourseTeacher\Adapter\FindCourseTeacherByIdQueryInterface;
use AppBundle\Query\CourseTeacher\Adapter\SearchCourseTeacherQueryInterface;
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
            'ldap_uns' => [
                'name' => 'Annuaire Ldap UNS',
                'searchService' => 'AppBundle\Query\CourseTeacher\Adapter\Ldap\SearchCourseTeacherLdapQuery',
                'findByIdService' => 'AppBundle\Query\CourseTeacher\Adapter\Ldap\FindCourseTeacherByIdLdapQuery'
            ],
            'othersource' => [
                'name' => 'Other source',
                'searchService' => 'OtherSearchService',
                'findByIdService' => 'OtherFindService'
            ],
            'sourcenotset' => [],
        ];
    }

    /**
     * @test
     */
    public function getSearchQuerySuccessful(){
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getSearchQuery('ldap_uns');
        $this->assertInstanceOf(SearchCourseTeacherQueryInterface::class, $importCourseTeacherQuery);
    }

    /**
     * @test
     */
    public function getFindQuerySuccessful(){
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getFindByIdQuery('ldap_uns');
        $this->assertInstanceOf(FindCourseTeacherByIdQueryInterface::class, $importCourseTeacherQuery);
    }

    /**
     * @test
     */
    public function sourcesNotFoundException(){
        $this->expectException(\Exception::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory([], $this->container);
        $this->assertNull($importCourseTeacherFactory);
    }

    /**
     * @test
     */
    public function sourcesIsNotArrayException(){
        $this->expectException(\Exception::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory(['sources' => null], $this->container);
        $this->assertNull($importCourseTeacherFactory);
    }

    /**
     * @test
     */
    public function getSearchQueryServiceNotFoundException(){
        $this->expectException(ServiceNotFoundException::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getSearchQuery('othersource');
        $this->assertNull($importCourseTeacherQuery);
    }

    /**
     * @test
     */
    public function getFindQueryServiceNotFoundException(){
        $this->expectException(ServiceNotFoundException::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getFindByIdQuery('othersource');
        $this->assertNull($importCourseTeacherQuery);
    }

    /**
     * @test
     */
    public function getSearchQuerySourceNotSetException(){
        $this->expectException(\Exception::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getSearchQuery('sourcenotset');
        $this->assertNull($importCourseTeacherQuery);
    }

    /**
     * @test
     */
    public function getFindQuerySourceNotSetException(){
        $this->expectException(\Exception::class);
        $importCourseTeacherFactory = new ImportCourseTeacherFactory($this->courseTeacherFactoryParams, $this->container);
        $importCourseTeacherQuery = $importCourseTeacherFactory->getFindByIdQuery('sourcenotset');
        $this->assertNull($importCourseTeacherQuery);
    }
}