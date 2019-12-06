<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\CourseInfo;
use AppBundle\Repository\CourseAchievementRepositoryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CoursePrerequisiteRepositoryInterface;
use AppBundle\Repository\CourseTutoringResourceRepositoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditObjectivesCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditObjectivesCourseInfoQuery
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
     * @param CourseInfo $courseInfo
     * @throws \Exception
     */
    public function execute(CourseInfo $courseInfo, CourseInfo $originalCourseInfo): void
    {
        try{
            // Keep an original course achievements copy
            $originalCourseAchievements = $originalCourseInfo->getCourseAchievements();
            // Keep an original course prerequisites copy
            $originalCoursePrerequisites = $originalCourseInfo->getCoursePrerequisites();
            // Keep an original course tutoring resources copy
            $originalCourseTutoringResources = $originalCourseInfo->getCourseTutoringResources();
            // Fill course info with new values
            //$courseInfo = $this->editObjectivesCourseInfoCommand->filledEntity($courseInfo);
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