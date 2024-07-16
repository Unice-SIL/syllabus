<?php

namespace App\Syllabus\Query\CourseTeacher\Adapter\Ldap;

use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Query\CourseTeacher\Adapter\FindCourseTeacherByIdQueryInterface;
use App\Ldap\Repository\TeacherRepositoryInterface;
use Exception;
use Symfony\Component\Uid\Uuid;

/**
 * Class FindCourseTeacherByIdLdapQuery
 * @package App\Syllabus\Query\CourseTeacher\Adapter\Ldap
 */
class FindCourseTeacherByIdLdapQuery implements FindCourseTeacherByIdQueryInterface
{
    /**
     * @var TeacherRepositoryInterface
     */
    private TeacherRepositoryInterface $teacherRepository;

    /**
     * @var string
     */
    private string $id;

    /**
     * FindCourseTeacherByIdLdapQuery constructor.
     * @param TeacherRepositoryInterface $teacherRepository
     */
    public function __construct(
        TeacherRepositoryInterface $teacherRepository
    )
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * @param string $id
     * @return FindCourseTeacherByIdQueryInterface
     */
    public function setId(string $id): FindCourseTeacherByIdQueryInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CourseTeacher|null
     * @throws Exception
     */
    public function execute(): ?CourseTeacher
    {
        $courseTeacher = null;
        try {
            $teacher = $this->teacherRepository->find($this->id);
            if (!is_null($teacher)){
                $courseTeacher = new CourseTeacher();
                $courseTeacher->setId(Uuid::v4())
                    ->setFirstname($teacher->getFirstname())
                    ->setLastname($teacher->getLastname())
                    ->setEmail($teacher->getEmail());
            }
        }catch (Exception $e){
            throw $e;
        }
        return $courseTeacher;
    }
}