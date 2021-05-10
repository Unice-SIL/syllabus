<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\CsvExtractor;
use App\Syllabus\Import\Extractor\ExtractorInterface;
use App\Syllabus\Import\Extractor\StructureApogeeExtractor;
use App\Syllabus\Import\Matching\MatchingInterface;
use App\Syllabus\Import\Matching\StructureApogeeMatching;
use App\Syllabus\Import\Matching\UserCsvMatching;
use App\Syllabus\Import\Transformer\ArrayTransformer;
use App\Syllabus\Import\Transformer\TransformerInterface;

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