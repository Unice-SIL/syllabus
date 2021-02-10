<?php

namespace App\Syllabus\Query\CourseTeacher\Adapter\Ldap;

use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Query\CourseTeacher\Adapter\FindCourseTeacherByIdQueryInterface;
use App\Ldap\Repository\TeacherRepositoryInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class FindCourseTeacherByIdLdapQuery
 * @package App\Syllabus\Query\CourseTeacher\Adapter\Ldap
 */
class FindCourseTeacherByIdLdapQuery implements FindCourseTeacherByIdQueryInterface
{
    /**
     * @var TeacherRepositoryInterface
     */
    private $teacherRepository;

    /**
     * @var string
     */
    private $id;

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
     * @throws \Exception
     */
    public function execute(): ?CourseTeacher
    {
        $courseTeacher = null;
        try {
            $teacher = $this->teacherRepository->find($this->id);
            if (!is_null($teacher)){
                $courseTeacher = new CourseTeacher();
                $courseTeacher->setId(Uuid::uuid4())
                    ->setFirstname($teacher->getFirstname())
                    ->setLastname($teacher->getLastname())
                    ->setEmail($teacher->getEmail());
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseTeacher;
    }
}