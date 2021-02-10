<?php


namespace App\Syllabus\Helper\Report;


class ReportMessage
{

    const TYPE_INFO = 'info';
    const TYPE_DANGER = 'danger';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';

    private $content;

    private $type = self::TYPE_INFO;

    /**
     * ReportMessage constructor.
     * @param $type
     * @param $content
     */
    public function __construct(string $content, string $type = null)
    {
        $this->content = $content;
        $this->type = $type ? $type : $this->type;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}