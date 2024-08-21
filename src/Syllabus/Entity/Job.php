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
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Job
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\JobTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_JOB_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_JOB_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_JOB_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_JOB_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_JOB_POST\')')],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_JOB\')'
    )
]
#[ORM\Entity]
#[ORM\Table(name: 'job')]
class Job
{
    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private int $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'label', type: 'string', length: 60)]
    #[Assert\NotBlank]
    private string $label;

    
    #[ORM\Column(name: 'command', type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: \App\Syllabus\Constant\Job::COMMANDS)]
    private string $command;

    
    #[ORM\Column(name: 'frequency_job_format', type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^(\*|((\*\/)?[1-5]?\d)) (\*|((\*\/)?1?\d|2?[0-3])) (\*|((\*\/)?([1-2]?\d|3[0-1]))) (\*|((\*\/)?\d|1[0-2])) (\*|((\*\/)?[0-6]))$/')]
    private string $frequencyJobFormat;

    
    #[ORM\Column(name: 'last_use_start', type: 'datetime', nullable: true)]
    #[Assert\DateTime]
    private ?DateTime $lastUseStart;

    
    #[ORM\Column(name: 'last_use_end', type: 'datetime', nullable: true)]
    #[Assert\DateTime]
    private ?DateTime $lastUseEnd;

    
    #[ORM\Column(name: 'last_status', type: 'integer', nullable: true)]
    #[Assert\Choice(choices: \App\Syllabus\Constant\Job::STATUSES)]
    private ?int $lastStatus = \App\Syllabus\Constant\Job::STATUS_INIT;

    
    #[ORM\Column(name: 'progress', type: 'integer', nullable: true)]
    private ?int $progress = 0;

    
    #[ORM\Column(name: 'memory_used', type: 'integer', nullable: true)]
    private ?int $memoryUsed = 0;

    
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    #[Assert\Type('bool')]
    private bool $obsolete = false;

    
    #[ORM\Column(name: 'immediately', type: 'boolean', nullable: false)]
    #[Assert\Type('bool')]
    private bool $immediately = false;

    
    #[ORM\Column(name: 'report', type: 'text', nullable: true)]
    private string $report;


    /**
     * Get id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set label.
     *
     *
     */
    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set command.
     *
     *
     */
    public function setCommand(string $command): static
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command.
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    public function getFrequencyJobFormat(): string
    {
        return $this->frequencyJobFormat;
    }

    public function setFrequencyJobFormat(string $frequencyJobFormat): void
    {
        $this->frequencyJobFormat = $frequencyJobFormat;
    }

    public function getLastStatus(): ?int
    {
        return $this->lastStatus;
    }

    /**
     * @param $lastStatus
     * @throws Exception
     */
    public function setLastStatus($lastStatus): void
    {
        if ($lastStatus !== \App\Syllabus\Constant\Job::STATUS_IN_PROGRESS) {
            $this->setLastUseEnd(new DateTime());
        }

        $this->lastStatus = $lastStatus;
    }

    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    public function setObsolete(bool $obsolete): void
    {
        $this->obsolete = $obsolete;
    }

    public function getLastUseStart(): ?DateTime
    {
        return $this->lastUseStart;
    }

    public function setLastUseStart(?DateTime $lastUseStart): void
    {
        $this->lastUseStart = $lastUseStart;
    }

    public function getLastUseEnd(): ?DateTime
    {
        return $this->lastUseEnd;
    }

    public function setLastUseEnd(?DateTime $lastUseEnd): void
    {
        $this->lastUseEnd = $lastUseEnd;
    }

    public function getReport(): string
    {
        return $this->report;
    }

    public function setReport(string $report): void
    {
        $this->report = $report;
    }

    public function isImmediately(): bool
    {
        return $this->immediately;
    }

    public function setImmediately(bool $immediately): void
    {
        $this->immediately = $immediately;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }

    public function setProgress(?int $progress): Job
    {
        $this->progress = $progress;
        return $this;
    }

    public function getMemoryUsed(): ?int
    {
        return $this->memoryUsed;
    }

    public function setMemoryUsed(?int $memoryUsed): Job
    {
        $this->memoryUsed = $memoryUsed;
        return $this;
    }


}
