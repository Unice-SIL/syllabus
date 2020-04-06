<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Transformer\TransformerInterface;

interface ConfigurationInterface
{
    public function getExtractor(): ExtractorInterface;

    public function getTransformer(): TransformerInterface;

    public function getMatching(): MatchingInterface;
}