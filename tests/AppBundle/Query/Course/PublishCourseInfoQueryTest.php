<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\EditMccCourseInfoCommand;
use AppBundle\Command\Course\PublishCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditMccCourseInfoQuery;
use AppBundle\Query\Course\PublishCourseInfoQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class PublishCourseInfoQueryTest
 * @package tests\AppBundle\Query\User
 */
class PublishCourseInfoQueryTest extends TestCase
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
     * @var PublishCourseInfoCommand
     */
    private $publishCourseInfoCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mocks Repositories
        $this->courseInfoRepository = $this->getMockBuilder('AppBundle\Repository\CourseInfoRepositoryInterface')
            ->getMock();

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo
            ->setId(Uuid::uuid4());

        // Command
        $this->publishCourseInfoCommand = new PublishCourseInfoCommand($this->courseInfo);
    }

    /**
     * Publish course info
     * @test
     */
    public function publishSuccessful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->publishCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $publishCourseInfoQuery = new PublishCourseInfoQuery($this->courseInfoRepository);
        $publishCourseInfoQuery->setPublishCourseInfoCommand($this->publishCourseInfoCommand);
        $this->assertNull($publishCourseInfoQuery->execute());
    }

    /**
     * Exception during CourseInfoRepository->update()
     * @test
     */
    public function edit1Exception(){
        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->publishCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo)
            ->willThrowException(new \Exception());

        $publishCourseInfoQuery = new PublishCourseInfoQuery($this->courseInfoRepository);
        $publishCourseInfoQuery->setPublishCourseInfoCommand($this->publishCourseInfoCommand)->execute();
    }

    /**
     * Edit throw CourseInfoNotFoundException
     * @test
     */
    public function editCourseNotFoundException(){
        $this->expectException(CourseInfoNotFoundException::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->publishCourseInfoCommand->getId())
            ->willReturn(null);

        $this->courseInfoRepository->expects($this->never())
            ->method('update')
            ->with($this->courseInfo);

        $publishCourseInfoQuery = new PublishCourseInfoQuery($this->courseInfoRepository);
        $publishCourseInfoQuery->setPublishCourseInfoCommand($this->publishCourseInfoCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseInfo);
        unset($this->editMccCourseInfoCommand);
    }
}