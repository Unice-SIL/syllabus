<?php


namespace AppBundle\Import\Transformer;


use AppBundle\Helper\Report\Report;
use AppBundle\Import\Matching\MatchingInterface;

interface TransformerInterface
{
    public function transform($dataToTransform, MatchingInterface $parser, array $options = [], Report $report = null): array;

}