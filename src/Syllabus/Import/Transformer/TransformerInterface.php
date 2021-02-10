<?php


namespace App\Syllabus\Import\Transformer;


use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Import\Matching\MatchingInterface;

interface TransformerInterface
{
    public function transform($dataToTransform, MatchingInterface $parser, array $options = [], Report $report = null): array;

}