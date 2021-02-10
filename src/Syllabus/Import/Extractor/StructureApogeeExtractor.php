<?php


namespace App\Syllabus\Import\Extractor;

use App\Syllabus\Helper\Report\Report;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

class StructureApogeeExtractor implements ExtractorInterface
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