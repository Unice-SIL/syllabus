<?php


namespace App\Syllabus\Entity;

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
 * AskAdvice
 *
 * @ORM\Table(name="ask_advice")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\AskAdviceTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_ASK_ADVICE_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_ASK_ADVICE_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_ASK_ADVICE_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_ASK_ADVICE_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_ASK_ADVICE_POST\')')
        ], filters: ['id.search_filter'],
        security: 'is_granted(\'ROLE_API_ASK_ADVICE\')'
    )
]
class AskAdvice
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private string $id;

    /**
     * @ORM\Column(name="description", type="text", options={"fixed"=true})
     * @Gedmo\Translatable
     */
    private mixed $description;

    /**
     * @ORM\Column(name="comment", type="text", options={"fixed"=true})
     * @Gedmo\Translatable
     */
    private mixed $comment;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    /**
     * @var CourseInfo
     *
     * @ORM\ManyToOne(targetEntity="CourseInfo")
     * @ORM\JoinColumn(name="course_info_id", referencedColumnName="id")
     */
    private CourseInfo $courseInfo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="process", type="boolean", options={"fixed"=true})
     */
    private bool $process = false;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return AskAdvice
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return AskAdvice
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment(): mixed
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return AskAdvice
     */
    public function setComment(mixed $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return CourseInfo
     */
    public function getCourseInfo(): CourseInfo
    {
        return $this->courseInfo;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return AskAdvice
     */
    public function setCourseInfo(CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProcess(): bool
    {
        return $this->process;
    }

    /**
     * @param bool $process
     * @return AskAdvice
     */
    public function setProcess(bool $process): self
    {
        $this->process = $process;
        return $this;
    }

}