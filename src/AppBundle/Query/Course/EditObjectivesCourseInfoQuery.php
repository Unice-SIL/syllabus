<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditObjectivesCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseAchievementRepositoryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CoursePrerequisiteRepositoryInterface;
use AppBundle\Repository\CourseTutoringResourceRepositoryInterface;
use Symfony\Component\Security\Core\Security;

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
     * @var CourseTutoringResourceRepositoryInterface
     */
    private $courseTutoringResourceRepository;

    /**
     * @var EditObjectivesCourseInfoCommand
     */
    private $editObjectivesCourseInfoCommand;

    /**
     * @var Security
     */
    private $security;

    /**
     * EditObjectivesCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseAchievementRepositoryInterface $courseAchievementRepository
     * @param CoursePrerequisiteRepositoryInterface $coursePrerequisiteRepository
     * @param CourseTutoringResourceRepositoryInterface $courseTutoringResourceRepository
     * @param Security $security
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseAchievementRepositoryInterface $courseAchievementRepository,
        CoursePrerequisiteRepositoryInterface $coursePrerequisiteRepository,
        CourseTutoringResourceRepositoryInterface $courseTutoringResourceRepository,
        Security $security
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseAchievementRepository = $courseAchievementRepository;
        $this->coursePrerequisiteRepository = $coursePrerequisiteRepository;
        $this->courseTutoringResourceRepository = $courseTutoringResourceRepository;
        $this->security = $security;
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
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found.', $this->editObjectivesCourseInfoCommand->getId()));
        }
        try{
            // Keep an original course achievements copy
            $originalCourseAchievements = $courseInfo->getCourseAchievements();
            // Keep an original course prerequisites copy
            $originalCoursePrerequisites = $courseInfo->getCoursePrerequisites();
            // Keep an original course tutoring resources copy
            $originalCourseTutoringResources = $courseInfo->getCourseTutoringResources();
            // Fill course info with new values
            $courseInfo = $this->editObjectivesCourseInfoCommand->filledEntity($courseInfo);
            $courseInfo->setModificationDate(new \DateTime())
                ->setLastUpdater($this->security->getUser());
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
            // Loop on original course tutoring resources to detect tutoring resources must be removed
            foreach ($originalCourseTutoringResources as $courseTutoringResource) {
                if (!$courseInfo->getCourseTutoringResources()->contains($courseTutoringResource)) {
                    $this->courseTutoringResourceRepository->delete($courseTutoringResource);
                }
            }

            // Update course infos
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}