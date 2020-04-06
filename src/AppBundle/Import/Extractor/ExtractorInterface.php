<?php


namespace AppBundle\Import\Extractor;


use AppBundle\Helper\Report\Report;

interface ExtractorInterface
{
    public function extract(Report $report = null, array $options = []);
}