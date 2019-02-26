<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditPresentationCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseTeacherRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class EditPresentationCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditPresentationCourseInfoQuery implements QueryInterface
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
     * EditPresentationCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseTeacherRepositoryInterface $courseTeacherRepository
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseTeacherRepositoryInterface $courseTeacherRepository
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseTeacherRepository = $courseTeacherRepository;
    }

    /**
     * @param EditPresentationCourseInfoCommand $editPresentationCourseInfoCommand
     * @return EditPresentationCourseInfoQuery
     */
    public function setEditPresentationCourseInfoCommand(EditPresentationCourseInfoCommand $editPresentationCourseInfoCommand): EditPresentationCourseInfoQuery
    {
        $this->editPresentationCourseInfoCommand = $editPresentationCourseInfoCommand;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function execute(): void
    {
        try {
            // Find CourseInfo
            $courseInfo = $this->courseInfoRepository->find($this->editPresentationCourseInfoCommand->getId());
            $originalCourseTeachers = $courseInfo->getCourseTeachers();
            $courseInfo = $this->editPresentationCourseInfoCommand->filledEntity($courseInfo);
            $this->courseInfoRepository->beginTransaction();
            foreach ($originalCourseTeachers as $courseTeacher) {
                if (!$courseInfo->getCourseTeachers()->contains($courseTeacher)) {
                    $this->courseTeacherRepository->delete($courseTeacher);
                }
            }
            dump($courseInfo);
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}