<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\CsvExtractor;
use App\Syllabus\Import\Extractor\ExtractorInterface;
use App\Syllabus\Import\Matching\CoursePermissionCsvMatching;
use App\Syllabus\Import\Transformer\ArrayTransformer;

class CoursePermissionCsvConfiguration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * @var
     */
    private $path;

    /**
     * CoursePermissionCsvConfiguration constructor.
     * @param CsvExtractor $csvExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CoursePermissionCsvMatching $CoursePermissionCsvMatching
     */
    public function __construct(CsvExtractor $csvExtractor, ArrayTransformer $arrayTransformer, CoursePermissionCsvMatching $CoursePermissionCsvMatching)
    {
        $this->extractor = $csvExtractor;
        $this->transformer = $arrayTransformer;
        $this->matching = $CoursePermissionCsvMatching;
    }

    /**
     * @return ExtractorInterface
     */
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