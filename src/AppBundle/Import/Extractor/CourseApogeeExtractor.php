<?php


namespace AppBundle\Import\Extractor;

use AppBundle\Helper\Report\Report;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class CourseApogeeExtractor
 * @package AppBundle\Import\Extractor
 */
class CourseApogeeExtractor implements ExtractorInterface
{

    /**
     * @var ObjectManager
     */
    private $em;

    private $conn;

    /**
     * @var array
     */
    private $apogeeCourseNatureToImport;

    /**
     * StructureApogeeExtractor constructor.
     * @param RegistryInterface $doctrine
     * @param array $apogeeCourseNatureToImport
     */
    public function __construct(RegistryInterface $doctrine, array $apogeeCourseNatureToImport = [])
    {
        $this->em = $doctrine->getManager('apogee');
        $this->conn = $doctrine->getConnection('apogee');
        $this->apogeeCourseNatureToImport = $apogeeCourseNatureToImport;
    }

    /**
     * @param Report|null $report
     * @param array $options
     * @return array
     */
    public function extract(Report $report = null, array $options = [])
    {

        $courses = [];
        $elps = [];

        if (isset($options['extractor']['filter']['code']))
        {
            $elps = $this->getElpParents($options['extractor']['filter']['code']);
        }
        else
        {
            $elps = $this->getElps();
        }


        foreach ($elps as $elp)
        {
            $courses[] = [
                'cod_elp' => $elp['COD_ELP'],
                'cod_cmp' => $elp['COD_CMP'],
                'cod_nel' => $elp['COD_NEL'],
                'lib_elp' => $elp['LIB_ELP'],
                'nbr_crd_elp' => $elp['NBR_CRD_ELP']
            ];
        }

        return $courses;
    }

    /**
     * @return mixed
     */
    private function getElps()
    {
        $natures = str_repeat('?,', count($this->apogeeCourseNatureToImport) - 1) . '?';
        $sql = "SELECT * FROM element_pedagogi elp
WHERE elp.cod_elp NOT IN (
SELECT ere.cod_elp_pere FROM elp_regroupe_elp ere WHERE ere.cod_elp_pere = elp.cod_elp)
AND elp.eta_elp = 'O' AND elp.tem_sus_elp = 'N' AND elp.cod_nel IN ({$natures})";
        $stmt = $this->conn->prepare($sql);
        foreach ($this->apogeeCourseNatureToImport as $k => $nature) $stmt->bindValue(($k+1), $nature);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $code
     * @return mixed
     */
    private function getElpParents($code)
    {
        $natures = str_repeat('?,', count($this->apogeeCourseNatureToImport) - 1) . '?';
        $sql = "SELECT elp.* FROM element_pedagogi elp
INNER JOIN elp_regroupe_elp ere ON (ere.cod_elp_pere = elp.cod_elp)
WHERE ere.cod_elp_fils = :cod_elp AND ere.eta_elp_fils = 'O' AND ere.eta_elp_pere = 'O'
AND ere.tem_sus_elp_fils = 'N' AND ere.tem_sus_elp_pere = 'N' AND elp.eta_elp = 'O' AND elp.tem_sus_elp = 'N'
AND elp.cod_nel IN ({$natures})";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':cod_elp', $code);
        foreach ($this->apogeeCourseNatureToImport as $k => $nature) $stmt->bindValue(($k+1), $nature);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}