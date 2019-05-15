<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditPresentationCourseInfoQuery;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditPresentationCourseInfoQueryTest
 * @package tests\Query\User
 */
class EditPresentationCourseInfoQueryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $courseInfoRepository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var MockObject
     */
    private $courseTeacherRepository;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var ArrayCollection
     */
    private $courseTeachers;

    /**
     * @var EditPresentationCourseInfoCommand
     */
    private $editPresentationCourseInfoCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mocks Repositories
        $this->courseInfoRepository = $this->getMockBuilder('AppBundle\Repository\CourseInfoRepositoryInterface')
            ->getMock();
        $this->courseTeacherRepository = $this->getMockBuilder('AppBundle\Repository\CourseTeacherRepositoryInterface')
            ->getMock();

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo
            ->setId(Uuid::uuid4())
            ->setPeriod('period')
            ->setSummary('summary')
            ->setMediaType('image')
            ->setImage('image.jpg')
            ->setVideo('https://domaine.com/video')
            ->setTeachingMode('class')
            ->setTeachingCmClass(2)
            ->setTeachingTdClass(4)
            ->setTeachingTpClass(6)
            ->setTeachingOtherClass(8)
            ->setTeachingCmHybridClass(10)
            ->setTeachingTdHybridClass(12)
            ->setTeachingTpHybridClass(14)
            ->setTeachingOtherHybridClass(16)
            ->setTeachingCmHybridDist(18)
            ->setTeachingTdHybridDist(20)
            ->setTeachingOtherHybridDist(22);

        // CourseTeachers
        $courseTeacher = new CourseTeacher();
        $courseTeacher->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setEmail('email')
            ->setManager(true);
        $this->courseTeachers = new ArrayCollection();
        $this->courseTeachers->add($courseTeacher);
        $this->courseInfo->setCourseTeachers($this->courseTeachers);

        // Command
        $this->editPresentationCourseInfoCommand = new EditPresentationCourseInfoCommand($this->courseInfo);

        // TokenStorage
        $this->tokenStorage = new TokenStorageInterface();
    }

    /**
     * Update presentation course info without removed teacher(s)
     * @test
     */
    public function edit1Successful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editPresentationCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseTeacherRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editPresentationCourseInfoQuery = new EditPresentationCourseInfoQuery($this->courseInfoRepository, $this->courseTeacherRepository);
        $editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand($this->editPresentationCourseInfoCommand);
        $this->assertNull($editPresentationCourseInfoQuery->execute());
    }

    /**
     * Update presentation course info with removed teacher(s)
     * @test
     */
    public function edit2Successful(){
        $teachers = $this->editPresentationCourseInfoCommand->getTeachers();
        $teachers->removeElement($teachers->first());

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editPresentationCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseTeacherRepository->expects($this->atLeastOnce())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editPresentationCourseInfoQuery = new EditPresentationCourseInfoQuery($this->courseInfoRepository, $this->courseTeacherRepository);
        $editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand($this->editPresentationCourseInfoCommand);
        $this->assertNull($editPresentationCourseInfoQuery->execute());
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

        $this->courseTeacherRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo)
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editPresentationCourseInfoQuery = new EditPresentationCourseInfoQuery($this->courseInfoRepository, $this->courseTeacherRepository);
        $editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand($this->editPresentationCourseInfoCommand)->execute();
    }

    /**
     * Exception during CourseTeacherRepository->delete()
     * @test
     */
    public function edit2Exception(){
        $teachers = $this->editPresentationCourseInfoCommand->getTeachers();
        $teachers->removeElement($teachers->first());

        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseTeacherRepository->expects($this->atLeastOnce())
            ->method('delete')
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('update');

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editPresentationCourseInfoQuery = new EditPresentationCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseTeacherRepository,
            $this->tokenStorage
        );
        $editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand($this->editPresentationCourseInfoCommand)->execute();
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

        $editPresentationCourseInfoQuery = new EditPresentationCourseInfoQuery($this->courseInfoRepository, $this->courseTeacherRepository);
        $editPresentationCourseInfoQuery->setEditPresentationCourseInfoCommand($this->editPresentationCourseInfoCommand)->execute();
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
    }
}