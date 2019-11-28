<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditPresentationCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditPresentationCourseInfoQuery
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var CourseTeacherRepositoryInterface
     */
    private $courseTeacherRepository;

    /**
     * @var EditPresentationCourseInfoCommand
     */
    private $editPresentationCourseInfoCommand;

    /**
     * @var Security
     */
    private $security;

    /**
     * EditPresentationCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseTeacherRepositoryInterface $courseTeacherRepository
     * @param Security $security
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseTeacherRepositoryInterface $courseTeacherRepository,
        Security $security
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseTeacherRepository = $courseTeacherRepository;
        $this->security = $security;
    }

    /**
     * @param CourseInfo $courseInfo
     * @param CourseInfo $originalCourseInfo
     * @throws \Exception
     */
    public function execute(CourseInfo $courseInfo, CourseInfo $originalCourseInfo): void
    {
        try {
            $courseInfo->setModificationDate(new \DateTime())
                ->setLastUpdater($this->security->getUser());
            $this->courseInfoRepository->beginTransaction();
            foreach ($originalCourseInfo as $courseTeacher) {
                if (!$courseInfo->getCourseTeachers()->contains($courseTeacher)) {
                    $this->courseTeacherRepository->delete($courseTeacher);
                }
            }
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        } catch(\Exception $e) {
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}