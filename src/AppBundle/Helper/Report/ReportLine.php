<?php


namespace AppBundle\Helper\Report;


class ReportLine
{
    private $id;

    private $comments = [];

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
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
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