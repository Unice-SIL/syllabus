<?php


namespace AppBundle\Import\Extractor;

use AppBundle\Helper\Report\Report;

class HourApogeeExtractor implements ExtractorInterface
{

    private $code;

    public function extract(Report $report = null, array $options = [])
    {

        return [
            [
                'cod_typ_heu' => 'CM',
                'nbr_heu_elp' => 4
            ],
            [
                'cod_typ_heu' => 'TD',
                'nbr_heu_elp' => 6
            ],
            [
                'cod_typ_heu' => 'TP',
                'nbr_heu_elp' => 8
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

}