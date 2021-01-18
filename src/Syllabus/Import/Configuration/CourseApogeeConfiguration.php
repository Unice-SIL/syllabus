<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\CourseApogeeExtractor;
use App\Syllabus\Import\Matching\CourseApogeeMatching;
use App\Syllabus\Import\Transformer\ArrayTransformer;

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