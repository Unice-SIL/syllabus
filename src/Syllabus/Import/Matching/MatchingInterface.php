<?php


namespace App\Syllabus\Import\Matching;


use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportLine;

interface MatchingInterface
{
    public function getNewEntity(): object;

    public function getLineIds(): array;

    public function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool;

    public function getCompleteMatching();

    public function getFields(string $type = 'source'): array;

}