<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditClosingRemarksCourseInfoQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditClosingRemarksCourseInfoQueryTest
 * @package tests\AppBundle\Query\User
 */
class EditClosingRemarksCourseInfoQueryTest extends TestCase
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
     * @var EditClosingRemarksCourseInfoCommand
     */
    private $editClosingRemarksCourseInfoCommand;

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
            ->setId(Uuid::uuid4())
            ->setClosingRemarks("closingremarks")
            ->setClosingVideo('https://tutube.com');

        // Command
        $this->editClosingRemarksCourseInfoCommand = new EditClosingRemarksCourseInfoCommand($this->courseInfo);
    }

    /**
     * Update presentation course info
     * @test
     */
    public function editSuccessful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editClosingRemarksCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editClosingRemarksCourseInfoQuery = new EditClosingRemarksCourseInfoQuery($this->courseInfoRepository);
        $editClosingRemarksCourseInfoQuery->setEditClosingRemarksCourseInfoCommand($this->editClosingRemarksCourseInfoCommand);
        $this->assertNull($editClosingRemarksCourseInfoQuery->execute());
    }

    /**
     * Exception during CourseInfoRepository->update()
     * @test
     */
    public function edit1Exception(){
        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

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

        $editClosingRemarksCourseInfoQuery = new EditClosingRemarksCourseInfoQuery($this->courseInfoRepository);
        $editClosingRemarksCourseInfoQuery->setEditClosingRemarksCourseInfoCommand($this->editClosingRemarksCourseInfoCommand)->execute();
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

        $this->courseInfoRepository->expects($this->never())
            ->method('beginTransaction');

        $this->courseInfoRepository->expects($this->never())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editClosingRemarksCourseInfoQuery = new EditClosingRemarksCourseInfoQuery($this->courseInfoRepository);
        $editClosingRemarksCourseInfoQuery->setEditClosingRemarksCourseInfoCommand($this->editClosingRemarksCourseInfoCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseInfo);
        unset($this->editClosingRemarksCourseInfoCommand);
    }
}