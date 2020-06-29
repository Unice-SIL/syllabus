<?php


namespace AppBundle\Import\Configuration;


use AppBundle\Import\Extractor\CoursePermissionMoodleExtractor;
use AppBundle\Import\Matching\CoursePermissionMoodleMatching;
use AppBundle\Import\Transformer\ArrayTransformer;

class CoursePermissionMoodleConfiguration extends AbstractConfiguration implements ConfigurationInterface
{

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
        $this->extractor = $coursePermissionMoodleExtractor;
        $this->transformer = $arrayTransformer;
        $this->matching = $coursePermissionMoodleMatching;
    }

}