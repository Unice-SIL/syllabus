<?php


namespace App\Syllabus\Helper\Report;


class ReportMessage
{

    const TYPE_INFO = 'info';
    const TYPE_DANGER = 'danger';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';

    private string $content;

    private string $type = self::TYPE_INFO;

    /**
     * @param string $content
     * @param string|null $type
     */
    public function __construct(string $content, string $type = null)
    {
        $this->content = $content;
        $this->type = $type ? $type : $this->type;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return void
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return void
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

}