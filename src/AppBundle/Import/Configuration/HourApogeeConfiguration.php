<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\HourApogeeExtractor;
use AppBundle\Import\Matching\HourApogeeMatching;
use AppBundle\Import\Transformer\ArrayTransformer;

/**
 * Class HourApogeeConfiguration
 * @package AppBundle\Import\Configuration
 */
class HourApogeeConfiguration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * HourApogeeConfiguration constructor.
     * @param HourApogeeExtractor $hourApogeeExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param HourApogeeMatching $hourApogeeMatching
     */
    public function __construct(HourApogeeExtractor $hourApogeeExtractor, ArrayTransformer $arrayTransformer, HourApogeeMatching $hourApogeeMatching)
    {
        $this->extractor = $hourApogeeExtractor;
        $this->transformer = $arrayTransformer;
        $this->matching = $hourApogeeMatching;
    }

}