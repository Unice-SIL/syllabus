<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CsvExtractor;
use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Matching\CourseInfoCsvMatching;
use AppBundle\Import\Transformer\ArrayTransformer;
use AppBundle\Import\Transformer\TransformerInterface;

class CourseInfoCsvConfiguration implements ConfigurationInterface
{
    /**
     * @var ArrayTransformer
     */
    private $arrayTransformer;
    /**
     * @var CourseInfoCsvMatching
     */
    private $courseInfoCsvMatching;

    private $path;
    /**
     * @var CsvExtractor
     */
    private $csvExtractor;

    /**
     * UserCsvConfiguration constructor.
     * @param CsvExtractor $csvExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CourseInfoCsvMatching $courseInfoCsvMatching
     */
    public function __construct(CsvExtractor $csvExtractor, ArrayTransformer $arrayTransformer, CourseInfoCsvMatching $courseInfoCsvMatching)
    {
        $this->csvExtractor = $csvExtractor;
        $this->arrayTransformer = $arrayTransformer;
        $this->courseInfoCsvMatching = $courseInfoCsvMatching;
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
        return $this->courseInfoCsvMatching;
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