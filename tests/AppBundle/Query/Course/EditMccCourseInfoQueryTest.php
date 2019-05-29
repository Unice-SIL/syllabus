<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\EditMccCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\User;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditMccCourseInfoQuery;
use Symfony\Component\Security\Core\Security;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditMccCourseInfoQueryTest
 * @package tests\AppBundle\Query\User
 */
class EditMccCourseInfoQueryTest extends TestCase
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
     * @var EditMccCourseInfoCommand
     */
    private $editMccCourseInfoCommand;

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
        $this->courseInfo
            ->setId(Uuid::uuid4())
            ->setMccAdvice('mccadvice');

        // User
        $this->user = new User();
        $this->user->setId(Uuid::uuid4());

        // Command
        $this->editMccCourseInfoCommand = new EditMccCourseInfoCommand($this->courseInfo);
    }

    /**
     * Update mcc course info
     * @test
     */
    public function editSuccessful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editMccCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editMccCourseInfoQuery = new EditMccCourseInfoQuery(
            $this->courseInfoRepository,
            $this->security
        );
        $editMccCourseInfoQuery->setEditMccCourseInfoCommand($this->editMccCourseInfoCommand);
        $this->assertNull($editMccCourseInfoQuery->execute());
    }

    /**
     * Exception during CourseInfoRepository->update()
     * @test
     */
    public function editException(){
        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo)
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editMccCourseInfoQuery = new EditMccCourseInfoQuery(
            $this->courseInfoRepository,
            $this->security
        );
        $editMccCourseInfoQuery->setEditMccCourseInfoCommand($this->editMccCourseInfoCommand)->execute();
    }

    /**
     * Edit throw CourseInfoNotFoundException
     * @test
     */
    public function editCourseNotFoundException(){
        $this->expectException(CourseInfoNotFoundException::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn(null);

        $this->security->expects($this->never())
            ->method('getUser');

        $this->courseInfoRepository->expects($this->never())
            ->method('beginTransaction');

        $this->courseInfoRepository->expects($this->never())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editMccCourseInfoQuery = new EditMccCourseInfoQuery(
            $this->courseInfoRepository,
            $this->security
        );
        $editMccCourseInfoQuery->setEditMccCourseInfoCommand($this->editMccCourseInfoCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseInfo);
        unset($this->editMccCourseInfoCommand);
        unset($this->security);
    }
}