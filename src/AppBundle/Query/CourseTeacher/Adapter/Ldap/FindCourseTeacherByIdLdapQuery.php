<?php

namespace AppBundle\Query\CourseTeacher\Adapter\Ldap;

use AppBundle\Entity\CourseTeacher;
use AppBundle\Query\CourseTeacher\Adapter\FindCourseTeacherByIdQueryInterface;
use LdapBundle\Repository\PeopleRepositoryInterface;

/**
 * Class FindCourseTeacherByIdLdapQuery
 * @package AppBundle\Query\CourseTeacher\Adapter\Ldap
 */
class FindCourseTeacherByIdLdapQuery implements FindCourseTeacherByIdQueryInterface
{
    /**
     * @var PeopleRepositoryInterface
     */
    private $peopleRepository;

    /**
     * @var string
     */
    private $id;

    /**
     * FindCourseTeacherByIdLdapQuery constructor.
     * @param PeopleRepositoryInterface $peopleRepository
     */
    public function __construct(
        PeopleRepositoryInterface $peopleRepository
    )
    {
        $this->peopleRepository = $peopleRepository;
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
            $people = $this->peopleRepository->find($this->id);
            if (!is_null($people)){
                $courseTeacher = new CourseTeacher();
                $courseTeacher->setId($people->getId())
                    ->setFirstname($people->getFirstname())
                    ->setLastname($people->getLastname())
                    ->setEmail($people->getEmail());
            }
        }catch (\Exception $e){
            throw $e;
        }
        return $courseTeacher;
    }
}