<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditActivitiesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseEvaluationCtRepositoryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseSectionActivityRepositoryInterface;
use AppBundle\Repository\CourseSectionRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
     * @var CourseEvaluationCtRepositoryInterface
     */
    private $courseEvaluationCtRepository;

    /**
     * @var EditActivitiesCourseInfoCommand
     */
    private $editActivitiesCourseInfoCommand;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * EditActivitiesCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseSectionRepositoryInterface $courseSectionRepository
     * @param CourseSectionActivityRepositoryInterface $courseSectionActivityRepository
     * @param CourseEvaluationCtRepositoryInterface $courseEvaluationCtRepository
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseSectionRepositoryInterface $courseSectionRepository,
        CourseSectionActivityRepositoryInterface $courseSectionActivityRepository,
        CourseEvaluationCtRepositoryInterface $courseEvaluationCtRepository,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseSectionRepository = $courseSectionRepository;
        $this->courseSectionActivityRepository = $courseSectionActivityRepository;
        $this->courseEvaluationCtRepository = $courseEvaluationCtRepository;
        $this->tokenStorage = $tokenStorage;
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
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found.', $this->editActivitiesCourseInfoCommand->getId()));
        }
        try{
            // Keep originals CourseSections before update
            $originalCourseSections = $courseInfo->getCourseSections()->getValues();
            // Keep originals CourseSectionActivities before update
            $originalCourseSectionActivities = [];
            foreach ($originalCourseSections as $originalCourseSection){
                $originalCourseSectionActivities[$originalCourseSection->getId()] = $originalCourseSection->getCourseSectionActivities()->getValues();
            }
            // Keep originals CourseEvaluations before update
            $originalCourseEvaluations = $courseInfo->getCourseEvaluationCts()->getValues();

            // Set course infos from command
            $courseInfo = $this->editActivitiesCourseInfoCommand->filledEntity($courseInfo);
            $courseInfo->setModificationDate(new \DateTime())
                ->setLastUpdater($this->tokenStorage->getToken()->getUser());
            // Start transaction
            $this->courseInfoRepository->beginTransaction();

            // Delete course sections and activities that need to be removed
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

            // Delete course evaluations that need to be removed
            foreach ($originalCourseEvaluations as $originalCourseEvaluation) {
                // Search original course evaluation in new course evaluations
                $courseEvaluationIndex = $courseInfo->getCourseEvaluationCts()->indexOf($originalCourseEvaluation);
                if ($courseEvaluationIndex === false) {
                    // If not found delete it
                    $this->courseEvaluationCtRepository->delete($originalCourseEvaluation);
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