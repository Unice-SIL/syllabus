<?php


namespace AppBundle\Import\Extractor;

use AppBundle\Helper\Report\Report;

class StructureApogeeExtractor implements ExtractorInterface
{

    public function extract(Report $report = null, array $options = [])
    {
        return [
            [
              'label' => 'Le label',
              'code' => 'Le code',
            ],
            [
            'label' => 'Le label 2',
            'code' => 'Le code 2',
            ],
        ];
    }

}