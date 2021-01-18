<?php


namespace App\Syllabus\Import;


use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Import\Configuration\ConfigurationInterface;
use App\Syllabus\Import\Extractor\ExtractorInterface;
use App\Syllabus\Import\Matching\MatchingInterface;
use App\Syllabus\Import\Transformer\TransformerInterface;

class ImportManager
{

    public function extract(ExtractorInterface $extractor, ?Report $report = null, $options = [])
    {

        return $extractor->extract($report);
    }

    public function parse(ExtractorInterface $extractor, TransformerInterface $transformer, MatchingInterface $matching, ?Report $report = null, $options = [])
    {

        $data = $extractor->extract($report, $options);

        return $transformer->transform($data, $matching, $options, $report);
    }

    public function parseFromConfig(ConfigurationInterface $configuration, ?Report $report = null, $options = [])
    {
        return $this->parse($configuration->getExtractor(), $configuration->getTransformer(), $configuration->getMatching(), $report, $options);
    }

    /*public function import()
    {

    }*/


}