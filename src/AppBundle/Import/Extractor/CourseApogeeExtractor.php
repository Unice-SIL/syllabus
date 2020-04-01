<?php


namespace AppBundle\Import\Extractor;

use AppBundle\Helper\Report\Report;

class CourseApogeeExtractor implements ExtractorInterface
{

    public function extract(Report $report = null, array $options = [])
    {

        $i = 1;
        $courses = [];
        while ($i<=1000) {
            $courses[] = [
                'cod_elp' => 'CODELP' . $i,
                'cod_cmp' => 'SCI',
                'cod_nel' => 'ECUE',
                'lib_elp' => 'Course import ' . $i,
                'nbr_crd_elp' => rand(1, 10)
            ];
            $i++;
        }
        return $courses;
    }

}