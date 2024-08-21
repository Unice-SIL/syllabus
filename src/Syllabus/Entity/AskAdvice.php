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
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * AskAdvice
 *
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
#[ORM\Entity]
#[ORM\Table(name: 'ask_advice')]
class AskAdvice
{
    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'description', type: 'text', options: ['fixed' => true])]
    private mixed $description;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'comment', type: 'text', options: ['fixed' => true])]
    private mixed $comment;

    
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    
    #[ORM\ManyToOne(targetEntity: CourseInfo::class)]
    #[ORM\JoinColumn(name: 'course_info_id', referencedColumnName: 'id')]
    private CourseInfo $courseInfo;

    
    #[ORM\Column(name: 'process', type: 'boolean', options: ['fixed' => true])]
    private bool $process = false;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): mixed
    {
        return $this->description;
    }

    /**
     * @param $description
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getComment(): mixed
    {
        return $this->comment;
    }

    public function setComment(mixed $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getCourseInfo(): CourseInfo
    {
        return $this->courseInfo;
    }

    public function setCourseInfo(CourseInfo $courseInfo): self
    {
        $this->courseInfo = $courseInfo;
        return $this;
    }

    public function isProcess(): bool
    {
        return $this->process;
    }

    public function setProcess(bool $process): self
    {
        $this->process = $process;
        return $this;
    }

}