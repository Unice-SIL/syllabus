<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Command\Course\EditEquipmentsCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;

/**
 * Class EditEquipmentsCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditEquipmentsCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var EditEquipmentsCourseInfoCommand
     */
    private $editEquipmentsCourseInfoCommand;

    /**
     * EditEquipmentsCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
    }

    /**
     * @param EditEquipmentsCourseInfoCommand $editEquipmentsCourseInfoCommand
     * @return EditEquipmentsCourseInfoQuery
     */
    public function setEditEquipmentsCourseInfoCommand(EditEquipmentsCourseInfoCommand $editEquipmentsCourseInfoCommand): EditEquipmentsCourseInfoQuery
    {
        $this->editEquipmentsCourseInfoCommand = $editEquipmentsCourseInfoCommand;
        return $this;
    }

    /**
     * @throws CourseInfoNotFoundException
     * @throws \Exception
     */
    public function execute(): void
    {
        try {
            // Find CourseInfo
            $courseInfo = $this->courseInfoRepository->find($this->editEquipmentsCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found', $this->editEquipmentsCourseInfoCommand->getId()));
        }
        try{
            $courseInfo = $this->editEquipmentsCourseInfoCommand->filledEntity($courseInfo);
            $this->courseInfoRepository->beginTransaction();
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}