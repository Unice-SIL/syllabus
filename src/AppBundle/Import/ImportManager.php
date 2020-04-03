<?php


namespace AppBundle\Import;


use AppBundle\Helper\Report\Report;
use AppBundle\Import\Configuration\ConfigurationInterface;
use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Transformer\TransformerInterface;

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