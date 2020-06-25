<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Transformer\TransformerInterface;

/**
 * Class AbstractConfiguration
 * @package AppBundle\Import\Configuration
 */
abstract class AbstractConfiguration
{
    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * @var MatchingInterface
     */
    protected $matching;

    /**
     * @var ExtractorInterface
     */
    protected $extractor;

    /**
     * @return ExtractorInterface
     */
    public function getExtractor(): ExtractorInterface
    {
        return $this->extractor;
    }

    /**
     * @return TransformerInterface
     */
    public function getTransformer(): TransformerInterface
    {
        return $this->transformer;
    }

    /**
     * @return MatchingInterface
     */
    public function getMatching(): MatchingInterface
    {
        return $this->matching;
    }
}