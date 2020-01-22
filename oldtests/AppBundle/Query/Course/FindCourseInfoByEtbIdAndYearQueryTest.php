<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Year;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\FindCourseInfoByEtbIdAndYearQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FindCourseInfoByEtbIdAndYearQueryTest
 * @package tests\AppBundle\Query\User
 */
class FindCourseInfoByEtbIdAndYearQueryTest extends TestCase
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
            ->setEtbId('Code1');

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
    public function findByEtbIdAndYearSuccessful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('findByEtbIdAndYear')
            ->with($this->courseInfo->getCourse()->getEtbId(), $this->courseInfo->getYear()->getId())
            ->willReturn($this->courseInfo);

        $findCourseInfoByEtbIdAndYearQuery = new FindCourseInfoByEtbIdAndYearQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByEtbIdAndYearQuery
            ->setEtbId($this->courseInfo->getCourse()->getEtbId())
            ->setYear($this->courseInfo->getYear()->getId())
            ->execute();
        $this->assertEquals($this->courseInfo, $courseInfo);
    }

    /**
     * @test
     */
    public function findByEtbIdAndYearException(){
        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('findByEtbIdAndYear')
            ->with($this->courseInfo->getCourse()->getEtbId(), $this->courseInfo->getYear()->getId())
            ->willThrowException(new \Exception());

        $findCourseInfoByEtbIdAndYearQuery = new FindCourseInfoByEtbIdAndYearQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByEtbIdAndYearQuery
            ->setEtbId($this->courseInfo->getCourse()->getEtbId())
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
            ->method('findByEtbIdAndYear')
            ->with($this->courseInfo->getCourse()->getEtbId(), $this->courseInfo->getYear()->getId())
            ->willReturn(null);

        $findCourseInfoByEtbIdAndYearQuery = new FindCourseInfoByEtbIdAndYearQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByEtbIdAndYearQuery
            ->setEtbId($this->courseInfo->getCourse()->getEtbId())
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