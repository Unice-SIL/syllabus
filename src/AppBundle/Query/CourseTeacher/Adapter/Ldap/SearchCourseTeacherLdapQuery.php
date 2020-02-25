<?php

namespace AppBundle\Query\CourseTeacher\Adapter\Ldap;
use AppBundle\Collection\CourseTeacherCollection;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Query\CourseTeacher\Adapter\SearchCourseTeacherQueryInterface;
use LdapBundle\Repository\TeacherRepositoryInterface;

/**
 * Class SearchCourseTeacherLdapQuery
 * @package AppBundle\Query\CourseTeacher\Adapter\Ldap
 */
class SearchCourseTeacherLdapQuery implements SearchCourseTeacherQueryInterface
{
    /**
     * @var TeacherRepositoryInterface
     */
    private $teacherRepository;

    /**
     * @var string
     */
    private $term;

    /**
     * ImportCourseTeacherLdapQuery constructor.
     * @param TeacherRepositoryInterface $teacherRepository
     */
    public function __construct(
        TeacherRepositoryInterface $teacherRepository
    )
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * @param string $term
     * @return SearchCourseTeacherLdapQuery
     */
    public function setTerm(string $term): SearchCourseTeacherQueryInterface
    {
        $this->term = $term;
        return $this;
    }

    /**
     * @return CourseTeacherCollection
     * @throws \Exception
     */
    public function execute(): CourseTeacherCollection
    {
        $courseTeachers = new CourseTeacherCollection();
        try {
            $teachers = $this->teacherRepository->search($this->term);
            foreach ($teachers as $teacher){
                $courseTeacher = new CourseTeacher();
                $courseTeacher->setId($teacher->getId())
                    ->setFirstname($teacher->getFirstname())
                    ->setLastname($teacher->getLastname())
                    ->setEmail($teacher->getEmail());
                $courseTeachers->append($courseTeacher);
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseTeachers;
    }
}