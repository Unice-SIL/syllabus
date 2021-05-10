<?php


namespace App\Syllabus\Import\Extractor;


use App\Syllabus\Helper\Report\Report;

interface ExtractorInterface
{
    public function extract(Report $report = null, array $options = []);
}