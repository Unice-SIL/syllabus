<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\CoursePermissionMoodleExtractor;
use App\Syllabus\Import\Matching\CoursePermissionMoodleMatching;
use App\Syllabus\Import\Transformer\ArrayTransformer;

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