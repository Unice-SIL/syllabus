<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Extractor\CourseApogeeExtractor;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Matching\CourseApogeeMatching;
use AppBundle\Import\Transformer\ArrayTransformer;
use AppBundle\Import\Transformer\TransformerInterface;

class CourseApogeeConfiguration implements ConfigurationInterface
{

    /**
     * @var ArrayTransformer
     */
    private $arrayTransformer;
    /**
     * @var CourseApogeeMatching
     */
    private $courseApogeeMatching;
    /**
     * @var CourseApogeeExtractor
     */
    private $courseApogeeExtractor;

    /**
     * UserCsvConfiguration constructor.
     * @param CourseApogeeExtractor $courseApogeeExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CourseApogeeMatching $courseApogeeMatching
     */
    public function __construct(CourseApogeeExtractor $courseApogeeExtractor, ArrayTransformer $arrayTransformer, CourseApogeeMatching $courseApogeeMatching)
    {
        $this->courseApogeeExtractor = $courseApogeeExtractor;
        $this->arrayTransformer = $arrayTransformer;
        $this->courseApogeeMatching = $courseApogeeMatching;
    }

    public function getExtractor(): ExtractorInterface
    {
        return $this->courseApogeeExtractor;
    }

    public function getTransformer(): TransformerInterface
    {
        return $this->arrayTransformer;
    }

    public function getMatching(): MatchingInterface
    {
        return $this->courseApogeeMatching;
    }

}