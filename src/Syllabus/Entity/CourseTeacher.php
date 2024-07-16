<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CourseTeacher
 *
 * @ORM\Table(name="course_teacher")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CourseTeacherTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_COURSE_TEACHER_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_COURSE_TEACHER_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_COURSE_TEACHER_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_COURSE_TEACHER_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_COURSE_TEACHER_POST\')')
        ],
        filters: ['id.search_filter', 'user.search_filter'],
        security: 'is_granted(\'ROLE_API_COURSE_TEACHER\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: ['id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: ['id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_teachers.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'user.search_filter']
    )
]
class CourseTeacher
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private ?string $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=100, nullable=true)
     */
    private ?string $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname", type="string", length=100, nullable=true)
     */
    private ?string $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private ?string $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="manager", type="boolean", nullable=false)
     */
    private bool $manager = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="email_visibility", type="boolean", nullable=false)
     */
    private bool $emailVisibility = false;

    /**
     * @var CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="App\Syllabus\Entity\CourseInfo", inversedBy="courseTeachers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="course_info_id", referencedColumnName="id", nullable=false)
     * })
     */
    private CourseInfo $courseInfo;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return CourseTeacher
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return CourseTeacher
     */
    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     * @return CourseTeacher
     */
    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return CourseTeacher
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return bool
     */
    public function isManager(): ?bool
    {
        return $this->manager;
    }

    /**
     * @param bool $manager
     * @return CourseTeacher
     */
    public function setManager(bool $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailVisibility(): ?bool
    {
        return $this->emailVisibility;
    }

    /**
     * @param bool $emailVisibility
     * @return CourseTeacher
     */
    public function setEmailVisibility(bool $emailVisibility): self
    {
        $this->emailVisibility = $emailVisibility;

        return $this;
    }


    /**
     * @return CourseInfo|null
     */
    public function getCourseInfo(): ?CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo|null $courseInfo
     * @return CourseTeacher
     */
    public function setCourseInfo(?CourseInfo $courseInfo): self
    {
        if($courseInfo !== $this->courseInfo)
        {
            $this->courseInfo = $courseInfo;
            if($courseInfo instanceof CourseInfo) $courseInfo->addCourseTeacher($this);
        }

        return $this;
    }

}
