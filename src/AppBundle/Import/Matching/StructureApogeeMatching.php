<?php


namespace AppBundle\Import\Matching;

use AppBundle\Entity\Structure;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Manager\StructureManager;

class StructureApogeeMatching extends AbstractMatching implements MatchingInterface
{

    private $structureManager;


    /**
     * StructureApogeeParser constructor.
     * @param StructureManager $structureManager
     */
    public function __construct(
        StructureManager $structureManager
    )
    {
        $this->structureManager = $structureManager;
    }

    public function getNewEntity(): object
    {
        return $this->structureManager->new();
    }

    public function getBaseMatching(): array
    {

        return [
            'code' => ['name' => 'code', 'required' => true, 'type'=> 'string', 'description' => "Code de la structure"],
            'label' => ['name' => 'label', 'required' => true, 'type'=> 'string', 'description' => "Label de la structure"],
        ];
    }

    public function getLineIds(): array
    {
        return ['code', 'label'];
    }

    /**
     * @param Structure $entity
     * @param string $property
     * @param string $name
     * @param string $type
     * @param $data
     * @param ReportLine $reportLine
     * @param Report $report
     * @return bool
     */
    public function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool
    {
        return true;
    }


}