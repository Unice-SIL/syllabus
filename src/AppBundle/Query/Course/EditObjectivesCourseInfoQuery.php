<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseAchievementRepositoryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CoursePrerequisiteRepositoryInterface;

/**
 * Class EditObjectivesCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditObjectivesCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var CourseAchievementRepositoryInterface
     */
    private $courseAchievementRepository;


    /**
     * @var CoursePrerequisiteRepositoryInterface
     */
    private $coursePrerequisiteRepository;

    /**
     * @var EditObjectivesCourseInfoCommand
     */
    private $editObjectivesCourseInfoCommand;

    /**
     * EditPresentationCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseAchievementRepositoryInterface $courseAchievementRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseAchievementRepositoryInterface $courseAchievementRepository,
        CoursePrerequisiteRepositoryInterface $coursePrerequisiteRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseAchievementRepository = $courseAchievementRepository;
        $this->coursePrerequisiteRepository = $coursePrerequisiteRepository;
    }

    /**
     * @param EditObjectivesCourseInfoCommand $editObjectivesCourseInfoCommand
     * @return EditObjectivesCourseInfoQuery
     */
    public function setEditObjectivesCourseInfoCommand(EditObjectivesCourseInfoCommand $editObjectivesCourseInfoCommand): EditObjectivesCourseInfoQuery
    {
        $this->editObjectivesCourseInfoCommand = $editObjectivesCourseInfoCommand;
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
            $courseInfo = $this->courseInfoRepository->find($this->editObjectivesCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found', $this->editObjectivesCourseInfoCommand->getId()));
        }
        try{
            // Keep an original course achievements copy
            $originalCourseAchievements = $courseInfo->getCourseAchievements();
            // Keep an original course prerequisites copy
            $originalCoursePrerequisites = $courseInfo->getCoursePrerequisites();
            // Fill course info with new values
            $courseInfo = $this->editObjectivesCourseInfoCommand->filledEntity($courseInfo);
            // Start transaction
            $this->courseInfoRepository->beginTransaction();
            // Loop on original course achievements to detect achieviements must be removed
            foreach ($originalCourseAchievements as $courseAchievement) {
                if (!$courseInfo->getCourseAchievements()->contains($courseAchievement)) {
                    $this->courseAchievementRepository->delete($courseAchievement);
                }
            }
            // Loop on original course prerequisites to detect prerequisites must be removed
            foreach ($originalCoursePrerequisites as $coursePrerequisite) {
                if (!$courseInfo->getCoursePrerequisites()->contains($coursePrerequisite)) {
                    $this->coursePrerequisiteRepository->delete($coursePrerequisite);
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