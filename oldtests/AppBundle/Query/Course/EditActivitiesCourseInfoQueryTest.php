<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\User;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditActivitiesCourseInfoQuery;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Security;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditPresentationCourseInfoQueryTest
 * @package tests\Query\User
 */
class EditActivitiesCourseInfoQueryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $courseInfoRepository;

    /**
     * @var MockObject
     */
    private $courseSectionRepository;

    /**
     * @var MockObject
     */
    private $courseSectionActivityRepository;

    /**
     * @var MockObject
     */
    private $courseEvaluationCtRepository;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var ArrayCollection
     */
    private $courseSections;

    /**
     * @var EditActivitiesCourseInfoCommand
     */
    private $editActivitiesCourseInfoCommand;

    /**
     * @var EditActivitiesCourseInfoQuery
     */
    private $editActivitiesCourseInfoQuery;

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
        $this->courseSectionRepository = $this->getMockBuilder('AppBundle\Repository\CourseSectionRepositoryInterface')
            ->getMock();
        $this->courseSectionActivityRepository = $this->getMockBuilder('AppBundle\Repository\CourseSectionActivityRepositoryInterface')
            ->getMock();
        $this->courseEvaluationCtRepository = $this->getMockBuilder('AppBundle\Repository\CourseEvaluationCtRepositoryInterface')
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

        // CourseSections
        $courseSection = new CourseSection();
        $courseSection->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setTitle('Chapitre 1')
            ->setDescription('Ceci est le chapitre 1');
        $this->courseSections = new ArrayCollection();
        $this->courseSections->add($courseSection);
        $this->courseInfo->setCourseSections($this->courseSections);

        // Command
        $this->editActivitiesCourseInfoCommand = new EditActivitiesCourseInfoCommand($this->courseInfo);

        $this->editActivitiesCourseInfoQuery = new EditActivitiesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseSectionRepository,
            $this->courseSectionActivityRepository,
            $this->courseEvaluationCtRepository,
            $this->security
        );
    }

    /**
     * Update presentation course info without removed section(s)
     * @test
     */
    public function edit1Successful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editActivitiesCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseSectionRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($this->editActivitiesCourseInfoCommand);
        $this->assertNull($this->editActivitiesCourseInfoQuery->execute());
    }

    /**
     * Update presentation course info with removed section(s)
     * @test
     */
    public function edit2Successful(){
        $sections = $this->editActivitiesCourseInfoCommand->getSections();
        $this->editActivitiesCourseInfoCommand->removeSection($sections->first());

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editActivitiesCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseSectionRepository->expects($this->atLeastOnce())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($this->editActivitiesCourseInfoCommand);
        $this->assertNull($this->editActivitiesCourseInfoQuery->execute());
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

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->user);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseSectionRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo)
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($this->editActivitiesCourseInfoCommand)->execute();
    }

    /**
     * Exception during CourseSectionRepository->delete()
     * @test
     */
    public function edit2Exception(){
        $sections = $this->editActivitiesCourseInfoCommand->getSections();
        $this->editActivitiesCourseInfoCommand->removeSection($sections->first());

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

        $this->courseSectionRepository->expects($this->atLeastOnce())
            ->method('delete')
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('update');

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($this->editActivitiesCourseInfoCommand)->execute();
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

        $this->editActivitiesCourseInfoQuery->setEditActivitiesCourseInfoCommand($this->editActivitiesCourseInfoCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseTeacherRepository);
        unset($this->courseInfo);
        unset($this->courseTeachers);
        unset($this->editPresentationCourseInfoCommand);
        unset($this->security);
    }
}