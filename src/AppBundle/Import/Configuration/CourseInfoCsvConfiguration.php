<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CsvExtractor;
use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\CourseInfoCsvMatching;
use AppBundle\Import\Transformer\ArrayTransformer;

class CourseInfoCsvConfiguration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * @var
     */
    private $path;

    /**
     * UserCsvConfiguration constructor.
     * @param CsvExtractor $csvExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CourseInfoCsvMatching $courseInfoCsvMatching
     */
    public function __construct(CsvExtractor $csvExtractor, ArrayTransformer $arrayTransformer, CourseInfoCsvMatching $courseInfoCsvMatching)
    {
        $this->extractor = $csvExtractor;
        $this->transformer = $arrayTransformer;
        $this->matching = $courseInfoCsvMatching;
    }

    public function getExtractor(): ExtractorInterface
    {
        $this->extractor->setPath($this->getPath());
        return $this->extractor;
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