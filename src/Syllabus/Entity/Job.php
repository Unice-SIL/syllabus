<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\JobTranslation")
 * @ApiResource(attributes={
 *     "filters"={"id.search_filter", "label.search_filter", "obsolete.boolean_filter"},
 *     "access_control"="is_granted('ROLE_API_JOB')",
 *     },
 *     collectionOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_JOB_GET')"},
 *          "post"={"method"="POST", "access_control"="is_granted('ROLE_API_JOB_POST')"}
 *     },
 *     itemOperations={
 *          "get"={"method"="GET", "access_control"="is_granted('ROLE_API_JOB_GET')"},
 *          "put"={"method"="PUT", "access_control"="is_granted('ROLE_API_JOB_PUT')"},
 *          "delete"={"method"="DELETE", "access_control"="is_granted('ROLE_API_JOB_DELETE')"},
 *     }
 * )
 */
class Job
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Syllabus\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=60)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Choice(choices=\App\Syllabus\Constant\Job::COMMANDS)
     */
    private $command;

    /**
     * @var string
     *
     * @ORM\Column(name="frequency_job_format", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^(\*|((\*\/)?[1-5]?[0-9])) (\*|((\*\/)?1?[0-9]|2?[0-3])) (\*|((\*\/)?([1-2]?[0-9]|3[0-1]))) (\*|((\*\/)?[0-9]|1[0-2])) (\*|((\*\/)?[0-6]))$/"
     * )
     */
    private $frequencyJobFormat;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_use_start", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $lastUseStart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_use_end", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $lastUseEnd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="last_status", type="integer", nullable=true)
     * @Assert\Choice(choices=\App\Syllabus\Constant\Job::STATUSES)
     */
    private $lastStatus = \App\Syllabus\Constant\Job::STATUS_INIT;

    /**
     *
     * @var int|null
     * @ORM\Column(name="progress", type="integer", nullable=true)
     */
    private $progress = 0;

    /**
     *
     * @var int|null
     * @ORM\Column(name="memory_used", type="integer", nullable=true)
     */
    private $memoryUsed = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     * @Assert\Type("bool")
     */
    private $obsolete = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="immediately", type="boolean", nullable=false)
     * @Assert\Type("bool")
     */
    private $immediately = false;

    /**
     * @var string
     *
     * @ORM\Column(name="report", type="text", nullable=true )
     */
    private $report;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
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
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel()
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
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command.
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getFrequencyJobFormat()
    {
        return $this->frequencyJobFormat;
    }

    /**
     * @param string $frequencyJobFormat
     */
    public function setFrequencyJobFormat($frequencyJobFormat)
    {
        $this->frequencyJobFormat = $frequencyJobFormat;
    }

    /**
     * @return int|null
     */
    public function getLastStatus()
    {
        return $this->lastStatus;
    }

    /**
     * @param $lastStatus
     * @throws \Exception
     */
    public function setLastStatus($lastStatus)
    {
        if ($lastStatus !== \App\Syllabus\Constant\Job::STATUS_IN_PROGRESS) {
            $this->setLastUseEnd(new \DateTime());
        }

        $this->lastStatus = $lastStatus;
    }

    /**
     * @return bool
     */
    public function isObsolete()
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     */
    public function setObsolete($obsolete)
    {
        $this->obsolete = $obsolete;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastUseStart()
    {
        return $this->lastUseStart;
    }

    /**
     * @param \DateTime|null $lastUseStart
     */
    public function setLastUseStart($lastUseStart)
    {
        $this->lastUseStart = $lastUseStart;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastUseEnd()
    {
        return $this->lastUseEnd;
    }

    /**
     * @param \DateTime|null $lastUseEnd
     */
    public function setLastUseEnd($lastUseEnd)
    {
        $this->lastUseEnd = $lastUseEnd;
    }

    /**
     * @return string
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @param string $report
     */
    public function setReport($report)
    {
        $this->report = $report;
    }

    /**
     * @return bool
     */
    public function isImmediately()
    {
        return $this->immediately;
    }

    /**
     * @param bool $immediately
     */
    public function setImmediately($immediately)
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
