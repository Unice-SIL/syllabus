<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Extractor\CourseParentApogeeExtractor;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Matching\CourseApogeeMatching;
use AppBundle\Import\Transformer\ArrayTransformer;
use AppBundle\Import\Transformer\TransformerInterface;

class CourseParentApogeeConfiguration implements ConfigurationInterface
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
     * @var CourseParentApogeeExtractor
     */
    private $courseParentApogeeExtractor;

    /**
     * UserCsvConfiguration constructor.
     * @param CourseParentApogeeExtractor $courseParentApogeeExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CourseApogeeMatching $courseApogeeMatching
     */
    public function __construct(CourseParentApogeeExtractor $courseParentApogeeExtractor, ArrayTransformer $arrayTransformer, CourseApogeeMatching $courseApogeeMatching)
    {
        $this->courseParentApogeeExtractor = $courseParentApogeeExtractor;
        $this->arrayTransformer = $arrayTransformer;
        $this->courseApogeeMatching = $courseApogeeMatching;
    }

    public function getExtractor(): ExtractorInterface
    {
        return $this->courseParentApogeeExtractor;
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