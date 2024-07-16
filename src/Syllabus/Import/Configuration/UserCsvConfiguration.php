<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\CsvExtractor;
use App\Syllabus\Import\Extractor\ExtractorInterface;
use App\Syllabus\Import\Matching\MatchingInterface;
use App\Syllabus\Import\Matching\UserCsvMatching;
use App\Syllabus\Import\Transformer\ArrayTransformer;
use App\Syllabus\Import\Transformer\TransformerInterface;

class UserCsvConfiguration implements ConfigurationInterface
{
    /**
     * @var ArrayTransformer
     */
    private ArrayTransformer $arrayTransformer;

    /**
     * @var UserCsvMatching
     */
    private UserCsvMatching $userCsvMatching;

    private mixed $path;

    /**
     * @var CsvExtractor
     */
    private CsvExtractor $csvExtractor;

    /**
     * UserCsvConfiguration constructor.
     * @param CsvExtractor $csvExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param UserCsvMatching $userCsvMatching
     */
    public function __construct(CsvExtractor $csvExtractor, ArrayTransformer $arrayTransformer, UserCsvMatching $userCsvMatching)
    {
        $this->csvExtractor = $csvExtractor;
        $this->arrayTransformer = $arrayTransformer;
        $this->userCsvMatching = $userCsvMatching;
    }

    public function getExtractor(): ExtractorInterface
    {

        $this->csvExtractor->setPath($this->getPath());
        return $this->csvExtractor;
    }

    public function getTransformer(): TransformerInterface
    {
        return $this->arrayTransformer;
    }

    public function getMatching(): MatchingInterface
    {
        return $this->userCsvMatching;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath(mixed $path): void
    {
        $this->path = $path;
    }

}