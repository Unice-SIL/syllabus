<?php


namespace App\Syllabus\Import\Extractor;

use App\Syllabus\Helper\Report\Report;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

class StructureApogeeExtractor implements ExtractorInterface
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
        $structures = [];

        $sql = "SELECT * FROM composante WHERE tem_en_sve_cmp='O'";
        $stmt = $this->conn->prepare($sql);
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