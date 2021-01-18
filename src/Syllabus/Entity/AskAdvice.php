<?php


namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AskAdvice
 *
 * @ORM\Table(name="ask_advice")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\AskAdviceTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter"},
 *     "access_control"="is_granted('ROLE_API_ASK_ADVICE')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_ASK_ADVICE_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_ASK_ADVICE_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_ASK_ADVICE_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_ASK_ADVICE_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_ASK_ADVICE_DELETE')"},
 *     }
 * )
 */
class AskAdvice
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @ORM\Column(name="description", type="text", options={"fixed"=true})
     * @Gedmo\Translatable
     */
    private $description;

    /**
     * @ORM\Column(name="comment", type="text", options={"fixed"=true})
     * @Gedmo\Translatable
     */
    private $comment;

    /**
     * @var User
     *
     * @ORM\Column(name="user", type="object", options={"fixed"=true})
     */
    private $user;

    /**
     * @var CourseInfo
     *
     * @ORM\Column(name="course_info", type="object", options={"fixed"=true})
     */
    private $courseInfo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="process", type="boolean", options={"fixed"=true})
     */
    private $process = false;

    /**
     * @return string
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
    public function getDescription()
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
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return AskAdvice
     */
    public function setComment($comment)
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