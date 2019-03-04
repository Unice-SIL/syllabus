<?php

namespace AppBundle\Query\CourseTeacher\Adapter\Ldap;

use AppBundle\Collection\CourseTeacherCollection;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Query\CourseTeacher\Adapter\SearchCourseTeacherQueryInterface;
use LdapBundle\Repository\PeopleRepositoryInterface;

/**
 * Class SearchCourseTeacherLdapQuery
 * @package AppBundle\Query\CourseTeacher\Adapter\Ldap
 */
class SearchCourseTeacherLdapQuery implements SearchCourseTeacherQueryInterface
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