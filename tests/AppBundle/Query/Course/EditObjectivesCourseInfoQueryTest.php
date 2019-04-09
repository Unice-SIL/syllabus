<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditObjectivesCourseInfoQuery;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditObjectivesCourseInfoQueryTest
 * @package tests\AppBundle\Query\User
 */
class EditObjectivesCourseInfoQueryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $courseInfoRepository;

    /**
     * @var MockObject
     */
    private $courseAchievementRepository;

    /**
     * @var MockObject
     */
    private $courseTutoringResourceRepository;

    /**
     * @var MockObject
     */
    private $coursePrerequisiteRepository;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var ArrayCollection
     */
    private $courseAchievements;

    /**
     * @var ArrayCollection
     */
    private $courseTutoringResources;

    /**
     * @var ArrayCollection
     */
    private $coursePrerequisites;

    /**
     * @var EditObjectivesCourseInfoCommand
     */
    private $editObjectivesCourseInfoCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mocks Repositories
        $this->courseInfoRepository = $this->getMockBuilder('AppBundle\Repository\CourseInfoRepositoryInterface')
            ->getMock();
        $this->courseAchievementRepository = $this->getMockBuilder('AppBundle\Repository\CourseAchievementRepositoryInterface')
            ->getMock();
        $this->courseTutoringResourceRepository = $this->getMockBuilder('AppBundle\Repository\CourseTutoringResourceRepositoryInterface')
            ->getMock();
        $this->coursePrerequisiteRepository = $this->getMockBuilder('AppBundle\Repository\CoursePrerequisiteRepositoryInterface')
            ->getMock();

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo
            ->setId(Uuid::uuid4())
            ->setTutoring(false);

        // CourseAchievements
        $courseAchievement = new CourseAchievement();
        $courseAchievement->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setDescription('achievement')
            ->setOrder(1);
        $this->courseAchievements = new ArrayCollection();
        $this->courseAchievements->add($courseAchievement);
        $this->courseInfo->setCourseAchievements($this->courseAchievements);

        // CourseTutoringResources
        $courseTutoringResource = new CourseTutoringResource();
        $courseTutoringResource->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setDescription('tutoring')
            ->setOrder(1);
        $this->courseTutoringResources = new ArrayCollection();
        $this->courseTutoringResources->add($courseTutoringResource);
        $this->courseInfo->setCourseTutoringResources($this->courseTutoringResources);

        // CoursePrerequisite
        $coursePrerequisite = new CoursePrerequisite();
        $coursePrerequisite->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setDescription('prerequisite')
            ->setOrder(1);
        $this->coursePrerequisites = new ArrayCollection();
        $this->coursePrerequisites->add($coursePrerequisite);
        $this->courseInfo->setCoursePrerequisites($this->coursePrerequisites);

        // Command
        $this->editObjectivesCourseInfoCommand = new EditObjectivesCourseInfoCommand($this->courseInfo);
    }

    /**
     * Update objectives course info without removal elements
     * @test
     */
    public function edit1Successful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editObjectivesCourseInfoCommand->getId())
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

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand);
        $this->assertNull($editObjectivesCourseInfoQuery->execute());
    }

    /**
     * Update objectives course info with removed achievement
     * @test
     */
    public function edit2Successful(){
        $achievements = $this->editObjectivesCourseInfoCommand->getAchievements();
        $achievements->removeElement($achievements->first());

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editObjectivesCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseAchievementRepository->expects($this->atLeastOnce())
            ->method('delete');

        $this->coursePrerequisiteRepository->expects($this->never())
            ->method('delete');

        $this->courseTutoringResourceRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand);
        $this->assertNull($editObjectivesCourseInfoQuery->execute());
    }

    /**
     * Update objectives course info with removed prerequisite
     * @test
     */
    public function edit3Successful(){
        $prerequisites = $this->editObjectivesCourseInfoCommand->getPrerequisites();
        $prerequisites->removeElement($prerequisites->first());

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editObjectivesCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseAchievementRepository->expects($this->never())
            ->method('delete');

        $this->coursePrerequisiteRepository->expects($this->atLeastOnce())
            ->method('delete');

        $this->courseTutoringResourceRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand);
        $this->assertNull($editObjectivesCourseInfoQuery->execute());
    }

    /**
     * Update objectives course info with removed prerequisite
     * @test
     */
    public function edit4Successful(){
        $tutoringResources = $this->editObjectivesCourseInfoCommand->getTutoringResources();
        $tutoringResources->removeElement($tutoringResources->first());

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editObjectivesCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseAchievementRepository->expects($this->never())
            ->method('delete');

        $this->coursePrerequisiteRepository->expects($this->never())
            ->method('delete');

        $this->courseTutoringResourceRepository->expects($this->atLeastOnce())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand);
        $this->assertNull($editObjectivesCourseInfoQuery->execute());
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

        $this->courseAchievementRepository->expects($this->never())
            ->method('delete');

        $this->coursePrerequisiteRepository->expects($this->never())
            ->method('delete');

        $this->courseTutoringResourceRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo)
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand)->execute();
    }

    /**
     * Exception during CourseAchievementsRepository->delete()
     * @test
     */
    public function edit2Exception(){
        $achievements = $this->editObjectivesCourseInfoCommand->getAchievements();
        $achievements->removeElement($achievements->first());

        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseAchievementRepository->expects($this->atLeastOnce())
            ->method('delete')
            ->willThrowException(new \Exception());

        $this->coursePrerequisiteRepository->expects($this->never())
            ->method('delete');

        $this->courseTutoringResourceRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->never())
            ->method('update');

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand)->execute();
    }

    /**
     * Exception during CoursePrerequisiteRepository->delete()
     * @test
     */
    public function edit3Exception(){
        $prerequisites = $this->editObjectivesCourseInfoCommand->getPrerequisites();
        $prerequisites->removeElement($prerequisites->first());

        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseAchievementRepository->expects($this->never())
            ->method('delete');

        $this->coursePrerequisiteRepository->expects($this->atLeastOnce())
            ->method('delete')
            ->willThrowException(new \Exception());

        $this->courseTutoringResourceRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->never())
            ->method('update');

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand)->execute();
    }

    /**
     * Exception during CoursePrerequisiteRepository->delete()
     * @test
     */
    public function edit4Exception(){
        $tutoringResources = $this->editObjectivesCourseInfoCommand->getTutoringResources();
        $tutoringResources->removeElement($tutoringResources->first());

        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseAchievementRepository->expects($this->never())
            ->method('delete');

        $this->coursePrerequisiteRepository->expects($this->never())
            ->method('delete');

        $this->courseTutoringResourceRepository->expects($this->atLeastOnce())
            ->method('delete')
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('update');

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand)->execute();
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

        $this->courseAchievementRepository->expects($this->never())
            ->method('delete');

        $this->coursePrerequisiteRepository->expects($this->never())
            ->method('delete');

        $this->courseTutoringResourceRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->never())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editObjectivesCourseInfoQuery = new EditObjectivesCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseAchievementRepository,
            $this->coursePrerequisiteRepository,
            $this->courseTutoringResourceRepository
        );
        $editObjectivesCourseInfoQuery->setEditObjectivesCourseInfoCommand($this->editObjectivesCourseInfoCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseAchievementRepository);
        unset($this->coursePrerequisiteRepository);
        unset($this->courseTutoringResourceRepository);
        unset($this->courseInfo);
        unset($this->courseAchievements);
        unset($this->coursePrerequisites);
        unset($this->courseTutoringResources);
        unset($this->editObjectivesCourseInfoCommand);
    }
}