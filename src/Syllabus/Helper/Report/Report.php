<?php


namespace App\Syllabus\Helper\Report;


use Doctrine\Common\Collections\ArrayCollection;


class Report
{
    private ArrayCollection $messages;

    private ArrayCollection $lines;

    /**
     * @var string|null
     */
    private ?string $title = 'Aucun';

    /**
     * Report constructor.
     * @param string|null $title
     */
    public function __construct(string $title = null)
    {
        $this->messages = new ArrayCollection();
        $this->lines = new ArrayCollection();
        if (null !== $title) {
            $this->setTitle($title);
        }

    }


    public function addMessage(ReportMessage $message): self
    {
        $this->messages->add($message);

        return $this;
    }

    public function getMessages(): ArrayCollection
    {
        return $this->messages;
    }

    public function addLine(ReportLine $reportLine): self
    {
        $this->lines->add($reportLine);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLines(): ArrayCollection
    {
        return $this->lines;
    }

    public function addLineIfHasComments(ReportLine $reportLine): bool
    {
        if (count($reportLine->getComments()) > 0) {
            $this->addLine($reportLine);
            return true;
        }

        return false;
    }

    public function createMessage(string $message, $type = null)
    {
        $this->addMessage(new ReportMessage($message, $type));
    }

    public function finishReport(int $totalLine)
    {
        $failedMessage = new ReportMessage($this->getLines()->count() . ' ligne(s) a/ont échoué', ReportMessage::TYPE_SUCCESS);
        $this->addMessage($failedMessage);

        if (!$this->getLines()->isEmpty()) {
            $failedMessage->setType(ReportMessage::TYPE_DANGER);
        }

        $this->addMessage(new ReportMessage($totalLine - $this->getLines()->count() . ' ligne(s) a/ont réussi', ReportMessage::TYPE_SUCCESS));
    }

    public function hasMessages()
    {
        return !$this->messages->isEmpty();
    }

    public function hasLines()
    {
        return !$this->lines->isEmpty();
    }

    public function addCommentToLine($error, string $lineIdReport): ?ReportLine
    {
        if (!$line = $this->getLineReport($lineIdReport)) {
            $line =  new ReportLine($lineIdReport);
            $this->addLine($line);
        }

        $line->addComment($error);

        return $line;
    }

    /**
     * @param string $lineIdReport
     * @return ReportLine|bool|null
     */
    public function getLineReport(string $lineIdReport)
    {
        return $this->getLines()->filter(function ($line) use($lineIdReport){return $line->getId() === $lineIdReport;})->first();
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

}