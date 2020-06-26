<?php


namespace AppBundle\Import\Extractor;

use AppBundle\Helper\Report\Report;
use Doctrine\DBAL\FetchMode;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HourApogeeExtractor implements ExtractorInterface
{

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * StructureApogeeExtractor constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->em = $doctrine->getManager('apogee');
    }

    /**
     * @param Report|null $report
     * @param array $options
     * @return array
     */
    public function extract(Report $report = null, array $options = [])
    {
        $courseHours = [];

        if (isset($options['extractor']['filter']['code'])  && isset($options['extractor']['filter']['year'])) {
            $conn = $this->em->getConnection();
            $sql = "SELECT * FROM elp_chg_typ_heu WHERE cod_elp = :cod_elp AND cod_anu = :cod_anu";
            $stmt = $conn->prepare($sql);
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