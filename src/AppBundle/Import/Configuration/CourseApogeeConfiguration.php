<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CourseApogeeExtractor;
use AppBundle\Import\Matching\CourseApogeeMatching;
use AppBundle\Import\Transformer\ArrayTransformer;

/**
 * Class CourseApogeeConfiguration
 * @package AppBundle\Import\Configuration
 */
class CourseApogeeConfiguration extends AbstractConfiguration implements ConfigurationInterface
{

    /**
     * CourseApogeeConfiguration constructor.
     * @param CourseApogeeExtractor $courseApogeeExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CourseApogeeMatching $courseApogeeMatching
     */
    public function __construct(CourseApogeeExtractor $courseApogeeExtractor, ArrayTransformer $arrayTransformer, CourseApogeeMatching $courseApogeeMatching)
    {
        $this->extractor = $courseApogeeExtractor;
        $this->transformer = $arrayTransformer;
        $this->matching = $courseApogeeMatching;
    }

}