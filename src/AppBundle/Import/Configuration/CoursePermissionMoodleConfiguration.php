<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CoursePermissionMoodleExtractor;
use AppBundle\Import\Extractor\ExtractorInterface;
use AppBundle\Import\Matching\CoursePermissionMoodleMatching;
use AppBundle\Import\Matching\MatchingInterface;
use AppBundle\Import\Transformer\ArrayTransformer;
use AppBundle\Import\Transformer\TransformerInterface;

class CoursePermissionMoodleConfiguration implements ConfigurationInterface
{
    /**
     * @var CoursePermissionMoodleExtractor
     */
    private $coursePermissionMoodleExtractor;
    /**
     * @var ArrayTransformer
     */
    private $arrayTransformer;
    /**
     * @var CoursePermissionMoodleMatching
     */
    private $coursePermissionMoodleMatching;

    /**
     * CoursePermissionMoodleConfiguration constructor.
     * @param CoursePermissionMoodleExtractor $coursePermissionMoodleExtractor
     * @param ArrayTransformer $arrayTransformer
     * @param CoursePermissionMoodleMatching $coursePermissionMoodleMatching
     */
    public function __construct(
        CoursePermissionMoodleExtractor $coursePermissionMoodleExtractor,
        ArrayTransformer $arrayTransformer,
        CoursePermissionMoodleMatching $coursePermissionMoodleMatching
    )
    {
        $this->coursePermissionMoodleExtractor = $coursePermissionMoodleExtractor;
        $this->arrayTransformer = $arrayTransformer;
        $this->coursePermissionMoodleMatching = $coursePermissionMoodleMatching;
    }

    public function getExtractor(): ExtractorInterface
    {
        return $this->coursePermissionMoodleExtractor;
    }

    public function getTransformer(): TransformerInterface
    {
        return $this->arrayTransformer;
    }

    public function getMatching(): MatchingInterface
    {
        return $this->coursePermissionMoodleMatching;
    }
}