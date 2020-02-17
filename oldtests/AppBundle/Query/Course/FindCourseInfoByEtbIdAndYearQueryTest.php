<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Year;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\FindCourseInfoByCodeAndYearQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FindCourseInfoByCodeAndYearQueryTest
 * @package tests\AppBundle\Query\User
 */
class FindCourseInfoByCodeAndYearQueryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $courseInfoRepository;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mock Repository
        $this->courseInfoRepository = $this->getMockBuilder('AppBundle\Repository\CourseInfoRepositoryInterface')
            ->getMock();

        // Course
        $course = new Course();
        $course->setId(Uuid::uuid4())
            ->setType('ECUE')
            ->setCode('Code1');

        // Year
        $year = new Year();
        $year->setId('2018')
            ->setLabel('2018-2019');

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo
            ->setId(Uuid::uuid4())
            ->setYear($year)
            ->setCourse($course);
    }

    /**
     * @test
     */
    public function findByCodeAndYearSuccessful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('findByCodeAndYear')
            ->with($this->courseInfo->getCourse()->getCode(), $this->courseInfo->getYear()->getId())
            ->willReturn($this->courseInfo);

        $findCourseInfoByCodeAndYearQuery = new FindCourseInfoByCodeAndYearQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByCodeAndYearQuery
            ->setCode($this->courseInfo->getCourse()->getCode())
            ->setYear($this->courseInfo->getYear()->getId())
            ->execute();
        $this->assertEquals($this->courseInfo, $courseInfo);
    }

    /**
     * @test
     */
    public function findByCodeAndYearException(){
        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('findByCodeAndYear')
            ->with($this->courseInfo->getCourse()->getCode(), $this->courseInfo->getYear()->getId())
            ->willThrowException(new \Exception());

        $findCourseInfoByCodeAndYearQuery = new FindCourseInfoByCodeAndYearQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByCodeAndYearQuery
            ->setCode($this->courseInfo->getCourse()->getCode())
            ->setYear($this->courseInfo->getYear()->getId())
            ->execute();
        $this->assertNull($courseInfo);
    }

    /**
     * @test
     */
    public function findByIdCourseInfoNotFoundException(){
        $this->expectException(CourseInfoNotFoundException::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('findByCodeAndYear')
            ->with($this->courseInfo->getCourse()->getCode(), $this->courseInfo->getYear()->getId())
            ->willReturn(null);

        $findCourseInfoByCodeAndYearQuery = new FindCourseInfoByCodeAndYearQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByCodeAndYearQuery
            ->setCode($this->courseInfo->getCourse()->getCode())
            ->setYear($this->courseInfo->getYear()->getId())
            ->execute();
        $this->assertNull($courseInfo);
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseInfo);
    }
}