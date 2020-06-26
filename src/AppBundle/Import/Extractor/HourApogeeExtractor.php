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
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private  $year;

    /**
     * StructureApogeeExtractor constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->em = $doctrine->getManager('apogee');
    }

    public function extract(Report $report = null, array $options = [])
    {
        $coursesHours = [];

        if (isset($this->code) && isset($this->year)) {

            $conn = $this->em->getConnection();
            $sql = "SELECT * FROM elp_chg_typ_heu WHERE cod_elp = :cod_elp AND cod_anu = :cod_anu";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':cod_elp', $this->code);
            $stmt->bindValue(':cod_anu', $this->year);
            $stmt->execute();
            foreach ($stmt->fetchAll(FetchMode::ASSOCIATIVE) as $courseHours) {
                $coursesHours[] = [
                    'cod_typ_heu' => $courseHours['COD_TYP_HEU'],
                    'nbr_heu_elp' => (float) $courseHours['NBR_HEU_ELP']
                ];
            }
        }

        return $coursesHours;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return HourApogeeExtractor
     */
    public function setCode(string $code): HourApogeeExtractor
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return HourApogeeExtractor
     */
    public function setYear(string $year): HourApogeeExtractor
    {
        $this->year = $year;
        return $this;
    }



}