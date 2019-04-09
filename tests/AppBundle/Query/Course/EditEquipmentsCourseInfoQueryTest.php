<?php

namespace tests\AppBundle\Query\User;

use AppBundle\Command\Course\EditEquipmentsCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseResourceEquipment;
use AppBundle\Entity\Equipment;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\Course\EditEquipmentsCourseInfoQuery;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * Class EditEquipmentsCourseInfoQueryTest
 * @package tests\AppBundle\Query\User
 */
class EditEquipmentsCourseInfoQueryTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $courseInfoRepository;

    /**
     * @var MockObject
     */
    private $courseResourceEquipmentRepository;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var ArrayCollection
     */
    private $courseResourceEquipments;

    /**
     * @var EditEquipmentsCourseInfoCommand
     */
    private $editEquipmentsCourseInfoCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        // Mocks Repositories
        $this->courseInfoRepository = $this->getMockBuilder('AppBundle\Repository\CourseInfoRepositoryInterface')
            ->getMock();
        $this->courseResourceEquipmentRepository = $this->getMockBuilder('AppBundle\Repository\CourseResourceEquipmentRepositoryInterface')
            ->getMock();

        // CourseInfo
        $this->courseInfo = new CourseInfo();
        $this->courseInfo
            ->setId(Uuid::uuid4())
            ->setEducationalResources('educationalResource')
            ->setBibliographicResources('bibliographicResource');

        // Equipment
        $equipment = new Equipment();
        $equipment->setId(Uuid::uuid4())
            ->setLabel('equipment')
            ->setLabelVisibility(true)
            ->setOrd(0);

        // CourseResourceEquipment
        $courseResourceEquipment = new CourseResourceEquipment();
        $courseResourceEquipment->setId(Uuid::uuid4())
            ->setCourseInfo($this->courseInfo)
            ->setEquipment($equipment)
            ->setDescription('description')
            ->setOrder(0);
        $this->courseResourceEquipments = new ArrayCollection();
        $this->courseResourceEquipments->add($courseResourceEquipment);
        $this->courseInfo->setCourseResourceEquipments($this->courseResourceEquipments);

        // Command
        $this->editEquipmentsCourseInfoCommand = new EditEquipmentsCourseInfoCommand($this->courseInfo);
    }

    /**
     * Update equipments course info without remove equipment
     * @test
     */
    public function edit1Successful(){
        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editEquipmentsCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseResourceEquipmentRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editEquipmentsCourseInfoQuery = new EditEquipmentsCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseResourceEquipmentRepository
        );
        $editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand($this->editEquipmentsCourseInfoCommand);
        $this->assertNull($editEquipmentsCourseInfoQuery->execute());
    }

    /**
     * Update equipments course info with removed equipment
     * @test
     */
    public function edit2Successful(){
        $equipments = $this->editEquipmentsCourseInfoCommand->getEquipments();
        $equipments->removeElement($equipments->first());

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->editEquipmentsCourseInfoCommand->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseResourceEquipmentRepository->expects($this->atLeastOnce())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('commit');

        $this->courseInfoRepository->expects($this->never())
            ->method('rollback');

        $editEquipmentsCourseInfoQuery = new EditEquipmentsCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseResourceEquipmentRepository
        );
        $editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand($this->editEquipmentsCourseInfoCommand);
        $this->assertNull($editEquipmentsCourseInfoQuery->execute());
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

        $this->courseResourceEquipmentRepository->expects($this->never())
            ->method('delete');

        $this->courseInfoRepository->expects($this->once())
            ->method('update')
            ->with($this->courseInfo)
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editEquipmentsCourseInfoQuery = new EditEquipmentsCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseResourceEquipmentRepository
        );
        $editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand($this->editEquipmentsCourseInfoCommand)->execute();
    }

    /**
     * Exception during CourseTeacherRepository->delete()
     * @test
     */
    public function edit2Exception(){
        $equipments = $this->editEquipmentsCourseInfoCommand->getEquipments();
        $equipments->removeElement($equipments->first());

        $this->expectException(\Exception::class);

        $this->courseInfoRepository->expects($this->once())
            ->method('find')
            ->with($this->courseInfo->getId())
            ->willReturn($this->courseInfo);

        $this->courseInfoRepository->expects($this->once())
            ->method('beginTransaction');

        $this->courseResourceEquipmentRepository->expects($this->atLeastOnce())
            ->method('delete')
            ->willThrowException(new \Exception());

        $this->courseInfoRepository->expects($this->never())
            ->method('update');

        $this->courseInfoRepository->expects($this->never())
            ->method('commit');

        $this->courseInfoRepository->expects($this->once())
            ->method('rollback');

        $editEquipmentsCourseInfoQuery = new EditEquipmentsCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseResourceEquipmentRepository
        );
        $editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand($this->editEquipmentsCourseInfoCommand)->execute();
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

        $editEquipmentsCourseInfoQuery = new EditEquipmentsCourseInfoQuery(
            $this->courseInfoRepository,
            $this->courseResourceEquipmentRepository
        );
        $editEquipmentsCourseInfoQuery->setEditEquipmentsCourseInfoCommand($this->editEquipmentsCourseInfoCommand)->execute();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        unset($this->courseInfoRepository);
        unset($this->courseResourceEquipmentRepository);
        unset($this->courseInfo);
        unset($this->courseResourceEquipments);
        unset($this->editEquipmentsCourseInfoCommand);
    }
}