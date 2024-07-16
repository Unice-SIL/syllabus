<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\CsvExtractor;
use App\Syllabus\Import\Extractor\ExtractorInterface;
use App\Syllabus\Import\Matching\CourseInfoCsvMatching;
use App\Syllabus\Import\Transformer\ArrayTransformer;

class CourseInfoCsvConfiguration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * @var
     */
    private mixed $path;

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
    public function getPath(): mixed
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