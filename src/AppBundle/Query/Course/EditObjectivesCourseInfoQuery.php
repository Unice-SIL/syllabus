<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseAchievementRepositoryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;

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
        CourseAchievementRepositoryInterface $courseAchievementRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseAchievementRepository = $courseAchievementRepository;
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
            $originalCourseAchievements = $courseInfo->getCourseAchievements();
            $courseInfo = $this->editObjectivesCourseInfoCommand->filledEntity($courseInfo);
            $this->courseInfoRepository->beginTransaction();
            foreach ($originalCourseAchievements as $courseAchievement) {
                if (!$courseInfo->getCourseAchievements()->contains($courseAchievement)) {
                    $this->courseAchievementRepository->delete($courseAchievement);
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