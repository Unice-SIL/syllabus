<?php


namespace App\Syllabus\Import\Extractor;

use App\Syllabus\Helper\Report\Report;
use Doctrine\DBAL\FetchMode;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class HourApogeeExtractor implements ExtractorInterface
{

    /**
     * @var object
     */
    private object $conn;

    /**
     * StructureApogeeExtractor constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->conn = $doctrine->getConnection('apogee');
    }

    /**
     * @param Report|null $report
     * @param array $options
     * @return array
     */
    public function extract(Report $report = null, array $options = []): array
    {
        $courseHours = [];

        if (isset($options['extractor']['filter']['code'])  && isset($options['extractor']['filter']['year'])) {
            $sql = "SELECT * FROM elp_chg_typ_heu WHERE cod_elp = :cod_elp AND cod_anu = :cod_anu";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':cod_elp', $options['extractor']['filter']['code']);
            $stmt->bindValue(':cod_anu', $options['extractor']['filter']['year']);
            $stmt->execute();
            foreach ($stmt->fetchAll(FetchMode::ASSOCIATIVE) as $courseHour) {
                $courseHours[] = [
                    'cod_typ_heu' => $courseHour['COD_TYP_HEU'],
                    'nbr_heu_elp' => $courseHour['NBR_HEU_ELP'],
                ];
            }
        }
        return $courseHours;
    }

}