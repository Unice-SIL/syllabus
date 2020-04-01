<?php


namespace AppBundle\Import\Extractor;

use AppBundle\Helper\Report\Report;

class CourseParentApogeeExtractor implements ExtractorInterface
{

    public function extract(Report $report = null, array $options = [])
    {
        if (isset($options['extractor']['filter']['code'])) {
            return [
                [
                    'cod_elp' => 'CODELP1_PARENT',
                    'cod_cmp' => 'SCI',
                    'cod_nel' => 'ECUE',
                    'lib_elp' => 'Course import 1 PARENT',
                    'nbr_crd_elp' => null
                ],
                [
                    'cod_elp' => 'CODELP2_PARENT',
                    'cod_cmp' => 'SCI',
                    'cod_nel' => 'ECUE',
                    'lib_elp' => 'Course import 2 PARENT',
                    'nbr_crd_elp' => null
                ],
            ];
        }

        throw new \Exception('Option "Code" is missing to build the sql query');
    }

}