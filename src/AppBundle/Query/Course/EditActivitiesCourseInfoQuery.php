<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseSectionRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;

/**
 * Class EditActivitiesCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditActivitiesCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var CourseTeacherRepositoryInterface
     */
    private $courseSectionRepository;

    /**
     * @var EditActivitiesCourseInfoCommand
     */
    private $editActivitiesCourseInfoCommand;

    /**
     * EditActivitiesCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseSectionRepositoryInterface $courseSectionRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseSectionRepositoryInterface $courseSectionRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseSectionRepository = $courseSectionRepository;
    }

    /**
     * @param EditActivitiesCourseInfoCommand $editActivitiesCourseInfoCommand
     * @return EditActivitiesCourseInfoQuery
     */
    public function setEditActivitiesCourseInfoCommand(EditActivitiesCourseInfoCommand $editActivitiesCourseInfoCommand): EditActivitiesCourseInfoQuery
    {
        $this->editActivitiesCourseInfoCommand = $editActivitiesCourseInfoCommand;
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
            $courseInfo = $this->courseInfoRepository->find($this->editActivitiesCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found', $this->editActivitiesCourseInfoCommand->getId()));
        }
        try{
            $originalCourseSections = $courseInfo->getCourseSections();
            $courseInfo = $this->editActivitiesCourseInfoCommand->filledEntity($courseInfo);
            $this->courseInfoRepository->beginTransaction();
            foreach ($originalCourseSections as $courseSection) {
                if (!$courseInfo->getCourseSections()->contains($courseSection)) {
                    $this->courseSectionRepository->delete($courseSection);
                }
            }
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}