<?php


namespace AppBundle\Import\Extractor;

use AppBundle\Helper\Report\Report;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CourseParentApogeeExtractor implements ExtractorInterface
{

    /**
     * @var ObjectManager
     */
    private $em;

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
        $this->apogeeCourseNatureToImport = $apogeeCourseNatureToImport;
    }

    public function extract(Report $report = null, array $options = [])
    {
        $courses = [];
        if (isset($options['extractor']['filter']['code'])) {
            $conn = $this->em->getConnection();
            $natures = str_repeat('?,', count($this->apogeeCourseNatureToImport) - 1) . '?';
            $sql = "SELECT elp.* FROM element_pedagogi elp
INNER JOIN elp_regroupe_elp ere ON (ere.cod_elp_pere = elp.cod_elp)
WHERE ere.cod_elp_fils = :cod_elp AND ere.eta_elp_fils = 'O' AND ere.eta_elp_pere = 'O'
AND ere.tem_sus_elp_fils = 'N' AND ere.tem_sus_elp_pere = 'N' AND elp.eta_elp = 'O' AND elp.tem_sus_elp = 'N'
AND elp.cod_nel IN ({$natures})";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':cod_elp', $options['extractor']['filter']['code']);
            foreach ($this->apogeeCourseNatureToImport as $k => $nature) $stmt->bindValue(($k+1), $nature);
            $stmt->execute();
            foreach($stmt->fetchAll() as $course)
            {
                $courses[] = [
                    'cod_elp' => $course['COD_ELP'],
                    'cod_cmp' => $course['COD_CMP'],
                    'cod_nel' => $course['COD_NEL'],
                    'lib_elp' => $course['LIB_ELP'],
                    'nbr_crd_elp' => $course['NBR_CRD_ELP']
                ];
            }
            return $courses;
        }

        throw new \Exception('Option "Code" is missing to build the sql query');
    }

}