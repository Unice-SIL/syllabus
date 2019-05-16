<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\PublishCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\User;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditMccCourseInfoQuery;
use AppBundle\Query\Course\PublishCourseInfoQuery;
use Symfony\Component\Security\Core\Security;
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
     * @var User
     */
    private $user;

    /**
     * @var Security
     */
    private $security;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mocks Repositories
        $this->courseInfoRepository = $this->getMockBuilder('AppBundle\Repository\CourseInfoRepositoryInterface')
            ->getMock();

        // Mock Security
        $this->security = $this
            ->getMockBuilder('Symfony\Component\Security\Core\Security')
            ->disableOriginalConstructor()
            ->getMock();

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo->setId(Uuid::uuid4());

        // User
        $this->user = new User();
        $this->user->setId(Uuid::uuid4());

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

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $publishCourseInfoQuery = new PublishCourseInfoQuery(
            $this->courseInfoRepository,
            $this->security
        );
        $publishCourseInfoQuery->setPublishCourseInfoCommand($this->publishCourseInfoCommand);
        $this->assertNull($publishCourseInfoQuery->execute());
    }

    /**
     * Exception during CourseInfoRepository->update()
     * @test
     */
    public function editException(){
        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->publishCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo)
            ->willThrowException(new \Exception());

        $publishCourseInfoQuery = new PublishCourseInfoQuery(
            $this->courseInfoRepository,
            $this->security
        );
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

        $this->security->expects($this->never())
            ->method('getUser');

        $this->courseInfoRepository->expects($this->never())
            ->method('update')
            ->with($this->courseInfo);

        $publishCourseInfoQuery = new PublishCourseInfoQuery(
            $this->courseInfoRepository,
            $this->security
        );
        $publishCourseInfoQuery->setPublishCourseInfoCommand($this->publishCourseInfoCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseInfo);
        unset($this->publishCourseInfoCommand);
        unset($this->security);
    }
}