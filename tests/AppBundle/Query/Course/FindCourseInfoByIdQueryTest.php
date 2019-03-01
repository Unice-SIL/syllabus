<?php

namespace tests\Query\User;

use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\FindCourseInfoByIdQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class FindCourseInfoByIdQueryTest
 * @package tests\Query\User
 */
class FindCourseInfoByIdQueryTest extends TestCase
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

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo
            ->setId(Uuid::uuid4());
    }

    /**
     * @test
     */
    public function findByIdSuccessful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

        $findCourseInfoByIdQuery = new FindCourseInfoByIdQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByIdQuery->setId($this->courseInfo->getId())->execute();
        $this->assertEquals($this->courseInfo, $courseInfo);
    }

    /**
     * @test
     */
    public function findByIdException(){
        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willThrowException(new \Exception());

        $findCourseInfoByIdQuery = new FindCourseInfoByIdQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByIdQuery->setId($this->courseInfo->getId())->execute();
        $this->assertNull($courseInfo);
    }

    /**
     * @test
     */
    public function findByIdCourseInfoNotFoundException(){
        $this->expectException(CourseInfoNotFoundException::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn(null);

        $findCourseInfoByIdQuery = new FindCourseInfoByIdQuery($this->courseInfoRepository);
        $courseInfo = $findCourseInfoByIdQuery->setId($this->courseInfo->getId())->execute();
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