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
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity
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
class Job
{
    /**
     * @var int
     *
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=60)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     */
    private string $label;

    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Choice(choices=\App\Syllabus\Constant\Job::COMMANDS)
     */
    private string $command;

    /**
     * @var string
     *
     * @ORM\Column(name="frequency_job_format", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^(\*|((\*\/)?[1-5]?[0-9])) (\*|((\*\/)?1?[0-9]|2?[0-3])) (\*|((\*\/)?([1-2]?[0-9]|3[0-1]))) (\*|((\*\/)?[0-9]|1[0-2])) (\*|((\*\/)?[0-6]))$/"
     * )
     */
    private string $frequencyJobFormat;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="last_use_start", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private ?DateTime $lastUseStart;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="last_use_end", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private ?DateTime $lastUseEnd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="last_status", type="integer", nullable=true)
     * @Assert\Choice(choices=\App\Syllabus\Constant\Job::STATUSES)
     */
    private ?int $lastStatus = \App\Syllabus\Constant\Job::STATUS_INIT;

    /**
     *
     * @var int|null
     * @ORM\Column(name="progress", type="integer", nullable=true)
     */
    private ?int $progress = 0;

    /**
     *
     * @var int|null
     * @ORM\Column(name="memory_used", type="integer", nullable=true)
     */
    private ?int $memoryUsed = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     * @Assert\Type("bool")
     */
    private bool $obsolete = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="immediately", type="boolean", nullable=false)
     * @Assert\Type("bool")
     */
    private bool $immediately = false;

    /**
     * @var string
     *
     * @ORM\Column(name="report", type="text", nullable=true )
     */
    private string $report;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return Job
     */
    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set command.
     *
     * @param string $command
     *
     * @return Job
     */
    public function setCommand(string $command): static
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command.
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getFrequencyJobFormat(): string
    {
        return $this->frequencyJobFormat;
    }

    /**
     * @param string $frequencyJobFormat
     */
    public function setFrequencyJobFormat(string $frequencyJobFormat): void
    {
        $this->frequencyJobFormat = $frequencyJobFormat;
    }

    /**
     * @return int|null
     */
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

    /**
     * @return bool
     */
    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     */
    public function setObsolete(bool $obsolete): void
    {
        $this->obsolete = $obsolete;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUseStart(): ?DateTime
    {
        return $this->lastUseStart;
    }

    /**
     * @param DateTime|null $lastUseStart
     */
    public function setLastUseStart(?DateTime $lastUseStart): void
    {
        $this->lastUseStart = $lastUseStart;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUseEnd(): ?DateTime
    {
        return $this->lastUseEnd;
    }

    /**
     * @param DateTime|null $lastUseEnd
     */
    public function setLastUseEnd(?DateTime $lastUseEnd): void
    {
        $this->lastUseEnd = $lastUseEnd;
    }

    /**
     * @return string
     */
    public function getReport(): string
    {
        return $this->report;
    }

    /**
     * @param string $report
     */
    public function setReport(string $report): void
    {
        $this->report = $report;
    }

    /**
     * @return bool
     */
    public function isImmediately(): bool
    {
        return $this->immediately;
    }

    /**
     * @param bool $immediately
     */
    public function setImmediately(bool $immediately): void
    {
        $this->immediately = $immediately;
    }

    /**
     * @return int|null
     */
    public function getProgress(): ?int
    {
        return $this->progress;
    }

    /**
     * @param int|null $progress
     * @return $this
     */
    public function setProgress(?int $progress): Job
    {
        $this->progress = $progress;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMemoryUsed(): ?int
    {
        return $this->memoryUsed;
    }

    /**
     * @param int|null $memoryUsed
     * @return Job
     */
    public function setMemoryUsed(?int $memoryUsed): Job
    {
        $this->memoryUsed = $memoryUsed;
        return $this;
    }


}
