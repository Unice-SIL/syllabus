<?php


namespace AppBundle\Helper\Report;


use Doctrine\Common\Collections\ArrayCollection;


class Report
{
    private $messages;

    private $lines;

    /**
     * Report constructor.
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->lines = new ArrayCollection();

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

        $this->addMessage(new ReportMessage($totalLine - $this->getLines()->count() . ' ligne(s) a/ont été importée(s) avec succès', ReportMessage::TYPE_SUCCESS));
    }

    public function hasMessages()
    {
        return !$this->messages->isEmpty();
    }

    public function hasLines()
    {
        return !$this->lines->isEmpty();
    }

    public function addCommentToLine($error, string $lineIdReport)
    {
        if (!$line = $this->getLineReport($lineIdReport)) {
            $line =  new ReportLine($lineIdReport);
            $this->addLine($line);
        }

        $line->addComment($error);

        return $line;
    }

    public function getLineReport(string $lineIdReport)
    {
        return $this->getLines()->filter(function ($line) use($lineIdReport){return $line->getId() === $lineIdReport;})->first();
    }

}