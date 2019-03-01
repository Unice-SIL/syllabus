<?php

namespace AppBundle\Query\CourseTeacher\Adapter\Ldap;

use AppBundle\Collection\CourseTeacherCollection;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Query\CourseTeacher\Adapter\ImportCourseTeacherQueryInterface;
use LdapBundle\Repository\PeopleRepositoryInterface;

/**
 * Class ImportCourseTeacherLdapQuery
 * @package AppBundle\Query\Adapter\Ldap
 */
class ImportCourseTeacherLdapQuery implements ImportCourseTeacherQueryInterface
{
    /**
     * @var PeopleRepositoryInterface
     */
    private $peopleRepository;

    /**
     * @var string
     */
    private $term;

    /**
     * ImportCourseTeacherLdapQuery constructor.
     * @param PeopleRepositoryInterface $peopleRepository
     */
    public function __construct(
        PeopleRepositoryInterface $peopleRepository
    )
    {
        $this->peopleRepository = $peopleRepository;
    }

    /**
     * @param string $term
     * @return ImportCourseTeacherLdapQuery
     */
    public function setTerm(string $term): ImportCourseTeacherLdapQuery
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
            $peoples = $this->peopleRepository->search($this->term);
            foreach ($peoples as $people){
                $courseTeacher = new CourseTeacher();
                $courseTeacher->setId($people->getId())
                    ->setFirstname($people->getFirstname())
                    ->setLastname($people->getLastname())
                    ->setEmail($people->getEmail());
                $courseTeachers->append($courseTeacher);
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseTeachers;
    }
}