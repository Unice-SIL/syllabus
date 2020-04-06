<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CsvExtractor;
use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Extractor\StructureApogeeExtractor;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Matching\StructureApogeeMatching;
use AppBundle\Import\Matching\UserCsvMatching;
use AppBundle\Import\Transformer\ArrayTransformer;
use AppBundle\Import\Transformer\TransformerInterface;

class StructureApogeeConfiguration implements ConfigurationInterface
{
    /**
     * @var ArrayTransformer
     */
    private $arrayTransformer;
    /**
     * @var StructureApogeeMatching
     */
    private $structureApogeeMatching;
    /**
     * @var StructureApogeeExtractor
     */
    private $structureApogeeExtractor;

    /**
     * UserCsvConfiguration constructor.
     * @param StructureApogeeExtractor $structureApogeeExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param StructureApogeeMatching $structureApogeeMatching
     */
    public function __construct(StructureApogeeExtractor $structureApogeeExtractor, ArrayTransformer $arrayTransformer, StructureApogeeMatching $structureApogeeMatching)
    {
        $this->structureApogeeExtractor = $structureApogeeExtractor;
        $this->arrayTransformer = $arrayTransformer;
        $this->structureApogeeMatching = $structureApogeeMatching;
    }

    public function getExtractor(): ExtractorInterface
    {
        return $this->structureApogeeExtractor;
    }

    public function getTransformer(): TransformerInterface
    {
        return $this->arrayTransformer;
    }

    public function getMatching(): MatchingInterface
    {
        return $this->structureApogeeMatching;
    }

}