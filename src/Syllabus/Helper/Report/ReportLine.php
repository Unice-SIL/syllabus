<?php


namespace App\Syllabus\Helper\Report;


class ReportLine
{
    private mixed $id;

    private array $comments = [];

    /**
     * ReportLine constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $id
     * @return ReportLine
     */
    public function setId(mixed $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }


    /**
     * @param string $comment
     * @return ReportLine
     */
    public function addComment(string $comment): self
    {
        $this->comments[] = $comment;
        return $this;
    }


}