<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CsvExtractor;
use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Matching\UserCsvMatching;
use AppBundle\Import\Transformer\ArrayTransformer;
use AppBundle\Import\Transformer\TransformerInterface;

class UserCsvConfiguration implements ConfigurationInterface
{
    /**
     * @var ArrayTransformer
     */
    private $arrayTransformer;
    /**
     * @var UserCsvMatching
     */
    private $userCsvMatching;

    private $path;
    /**
     * @var CsvExtractor
     */
    private $csvExtractor;

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
    public function setPath($path): void
    {
        $this->path = $path;
    }

}