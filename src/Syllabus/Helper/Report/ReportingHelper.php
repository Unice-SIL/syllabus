<?php


namespace App\Syllabus\Helper\Report;


class ReportingHelper
{
    public static function createReport(string $title = null)
    {
        return new Report($title);
    }
}