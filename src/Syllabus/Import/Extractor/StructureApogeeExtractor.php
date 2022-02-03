<?php


namespace App\Syllabus\Import\Extractor;

use App\Syllabus\Helper\Report\Report;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class StructureApogeeExtractor implements ExtractorInterface
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * StructureApogeeExtractor constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager('apogee');
    }

    /**
     * @param Report|null $report
     * @param array $options
     * @return \string[][]
     */
    public function extract(Report $report = null, array $options = [])
    {
        $structures = [];

        $conn = $this->em->getConnection();
        $sql = "SELECT * FROM composante WHERE tem_en_sve_cmp='O'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $structure)
        {
            $structures[] = [
                'code' => $structure['COD_CMP'],
                'label' => $structure['LIB_CMP']
            ];
        }

        return $structures;
    }

}