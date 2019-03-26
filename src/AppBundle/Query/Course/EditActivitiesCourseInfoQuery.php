<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseSectionActivityRepositoryInterface;
use AppBundle\Repository\CourseSectionRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var CourseSectionActivityRepositoryInterface
     */
    private $courseSectionActivityRepository;

    /**
     * @var EditActivitiesCourseInfoCommand
     */
    private $editActivitiesCourseInfoCommand;

    /**
     * EditActivitiesCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseSectionRepositoryInterface $courseSectionRepository
     * @param CourseSectionActivityRepositoryInterface $courseSectionActivityRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseSectionRepositoryInterface $courseSectionRepository,
        CourseSectionActivityRepositoryInterface $courseSectionActivityRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseSectionRepository = $courseSectionRepository;
        $this->courseSectionActivityRepository = $courseSectionActivityRepository;
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
            $originalCourseInfo = clone $courseInfo;
            // Keep originals CourseSection before update
            $originalCourseSections = $courseInfo->getCourseSections()->getValues();
            // Keep originals CourseSectionActivities before update
            $originalCourseSectionActivities = [];
            foreach ($originalCourseSections as $originalCourseSection){
                $originalCourseSectionActivities[$originalCourseSection->getId()] = $originalCourseSection->getCourseSectionActivities()->getValues();
            }
            // Set course infos from command
            $courseInfo = $this->editActivitiesCourseInfoCommand->filledEntity($courseInfo);
            dump($originalCourseInfo, $courseInfo);
            // Start transaction
            $this->courseInfoRepository->beginTransaction();
            // Deletes course sections and activities that need to be removed
            foreach ($originalCourseSections as $originalCourseSection) {
                // Search original course section in new course sections
                $courseSectionIndex = $courseInfo->getCourseSections()->indexOf($originalCourseSection);
                if ($courseSectionIndex === false) {
                    // If not found delete it
                    $this->courseSectionRepository->delete($originalCourseSection);
                }else{
                    // Get new course section activities
                    $courseSection = $courseInfo->getCourseSections()->offsetGet($courseSectionIndex);
                    foreach ($originalCourseSectionActivities[$courseSection->getId()] as $originalCourseSectionActivity){
                        // Search original course section activity in new course section activities
                        $courseSectionActivityIndex = $courseSection->getCourseSectionActivities()->indexOf($originalCourseSectionActivity);
                        if($courseSectionActivityIndex === false){
                            // If not found delete it
                            $this->courseSectionActivityRepository->delete($originalCourseSectionActivity);
                        }
                    }
                }
            }
            // Update course infos in repository
            $this->courseInfoRepository->update($courseInfo);
            // Commit
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}