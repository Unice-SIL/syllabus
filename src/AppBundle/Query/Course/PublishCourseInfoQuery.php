<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Command\Course\PublishCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;

/**
 * Class PublishCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class PublishCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var PublishCourseInfoCommand
     */
    private $publishCourseInfoCommand;

    /**
     * PublishCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
    }

    /**
     * @param PublishCourseInfoCommand $publishCourseInfoCommand
     * @return PublishCourseInfoQuery
     */
    public function setPublishCourseInfoCommand(PublishCourseInfoCommand $publishCourseInfoCommand): PublishCourseInfoQuery
    {
        $this->publishCourseInfoCommand = $publishCourseInfoCommand;
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
            $courseInfo = $this->courseInfoRepository->find($this->publishCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found', $this->publishCourseInfoCommand->getId()));
        }
        try{
            $courseInfo = $this->publishCourseInfoCommand->filledEntity($courseInfo);
            $this->courseInfoRepository->update($courseInfo);
        }catch (\Exception $e){
            throw $e;
        }
    }
}