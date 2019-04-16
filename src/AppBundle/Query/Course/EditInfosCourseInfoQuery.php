<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditInfosCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;

/**
 * Class EditInfosCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditInfosCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var EditInfosCourseInfoCommand
     */
    private $editInfosCourseInfoCommand;

    /**
     * EditInfosCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
    }

    /**
     * @param EditInfosCourseInfoCommand $editInfosCourseInfoCommand
     * @return EditInfosCourseInfoQuery
     */
    public function setEditInfosCourseInfoCommand(EditInfosCourseInfoCommand $editInfosCourseInfoCommand): EditInfosCourseInfoQuery
    {
        $this->editInfosCourseInfoCommand = $editInfosCourseInfoCommand;
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
            $courseInfo = $this->courseInfoRepository->find($this->editInfosCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found.', $this->editInfosCourseInfoCommand->getId()));
        }
        try{
            $courseInfo = $this->editInfosCourseInfoCommand->filledEntity($courseInfo);
            $this->courseInfoRepository->beginTransaction();
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}