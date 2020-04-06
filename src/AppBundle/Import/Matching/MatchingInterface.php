<?php


namespace AppBundle\Import\Matching;


use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportLine;

interface MatchingInterface
{
    public function getNewEntity(): object;

    public function getLineIds(): array;

    public function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool;

    public function getCompleteMatching();

    public function getFields($type = 'source'): array;

}