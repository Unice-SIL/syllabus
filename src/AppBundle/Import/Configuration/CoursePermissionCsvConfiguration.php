<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CsvExtractor;
use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Matching\CoursePermissionCsvMatching;
use AppBundle\Import\Transformer\ArrayTransformer;
use AppBundle\Import\Transformer\TransformerInterface;

class CoursePermissionCsvConfiguration implements ConfigurationInterface
{
    /**
     * @var ArrayTransformer
     */
    private $arrayTransformer;
    /**
     * @var CoursePermissionCsvMatching
     */
    private $CoursePermissionCsvMatching;

    private $path;
    /**
     * @var CsvExtractor
     */
    private $csvExtractor;

    /**
     * CoursePermissionCsvConfiguration constructor.
     * @param CsvExtractor $csvExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CoursePermissionCsvMatching $CoursePermissionCsvMatching
     */
    public function __construct(CsvExtractor $csvExtractor, ArrayTransformer $arrayTransformer, CoursePermissionCsvMatching $CoursePermissionCsvMatching)
    {
        $this->csvExtractor = $csvExtractor;
        $this->arrayTransformer = $arrayTransformer;
        $this->CoursePermissionCsvMatching = $CoursePermissionCsvMatching;
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
        return $this->CoursePermissionCsvMatching;
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