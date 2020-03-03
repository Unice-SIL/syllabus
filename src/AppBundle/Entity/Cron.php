<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cron
 *
 * @ORM\Table(name="cron")
 * @ORM\Entity
 */
class Cron
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string", length=36, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="AppBundle\Doctrine\IdGenerator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=60)
     * @Assert\NotBlank()
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="command", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Choice(choices=\AppBundle\Constant\Cron::COMMANDS)
     */
    private $command;

    /**
     * @var string
     *
     * @ORM\Column(name="frequency_cron_format", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^(\*|((\*\/)?[1-5]?[0-9])) (\*|((\*\/)?1?[0-9]|2?[0-3])) (\*|((\*\/)?([1-2]?[0-9]|3[0-1]))) (\*|((\*\/)?[0-9]|1[0-2])) (\*|((\*\/)?[0-6]))$/"
     * )
     */
    private $frequencyCronFormat;

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
     * @Assert\Choice(choices=\AppBundle\Constant\Cron::STATUSES)
     */
    private $lastStatus = \AppBundle\Constant\Cron::STATUS_INIT;

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
     * @return Cron
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
     * @return Cron
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
    public function getFrequencyCronFormat()
    {
        return $this->frequencyCronFormat;
    }

    /**
     * @param string $frequencyCronFormat
     */
    public function setFrequencyCronFormat($frequencyCronFormat)
    {
        $this->frequencyCronFormat = $frequencyCronFormat;
    }

    /**
     * @return int|null
     */
    public function getLastStatus()
    {
        return $this->lastStatus;
    }

    /**
     * @param int|null $lastStatus
     */
    public function setLastStatus($lastStatus)
    {
        if ($lastStatus !== \AppBundle\Constant\Cron::STATUS_IN_PROGRESS) {
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

}
