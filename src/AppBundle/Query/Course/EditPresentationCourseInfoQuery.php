<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;
use Ramsey\Uuid\Uuid;
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

            dump($courseInfo);

            /** @var CourseTeacher $courseTeacher */
            foreach ($courseInfo->getCourseTeachers() as $offset => $courseTeacher)
            {
                if(empty($courseTeacher->getId()))
                {
                    $courseTeacher->setId(Uuid::uuid4());
                }
            }

            dump($courseInfo);

            /** @var CourseTeacher $courseTeacher */
            foreach ($originalCourseInfo as $courseTeacher) {
                if (!$courseInfo->getCourseTeachers()->contains($courseTeacher)) {
                    $this->courseTeacherRepository->delete($courseTeacher);
                }
            }

            dump($courseInfo);

            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        } catch(\Exception $e) {
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}