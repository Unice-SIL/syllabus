<?php


namespace AppBundle\Import\Extractor;


use AppBundle\Helper\Report\Report;

class CoursePermissionMoodleExtractor implements ExtractorInterface
{
    public function extract(Report $report = null, array $options = [])
    {
        $permissions = [];

        $i = 1;
        while ($i<=1000) {
            $permissions[] =             [
                'username' => 'Salim',
                'code' => 'CODELP' . $i++
            ];
        }

        return $permissions;
    }

}