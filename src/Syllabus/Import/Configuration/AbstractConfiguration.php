<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\ExtractorInterface;
use App\Syllabus\Import\Matching\MatchingInterface;
use App\Syllabus\Import\Transformer\TransformerInterface;

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