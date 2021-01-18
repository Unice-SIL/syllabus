<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\HourApogeeExtractor;
use App\Syllabus\Import\Matching\HourApogeeMatching;
use App\Syllabus\Import\Transformer\ArrayTransformer;

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