<?php


namespace AppBundle\Import\Matching;

use AppBundle\Entity\Course;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Import\ImportManager;
use AppBundle\Manager\TeachingManager;

/**
 * Class HourApogeeMatching
 * @package AppBundle\Import\Matching
 */
class HourApogeeMatching extends AbstractMatching implements MatchingInterface
{
    /**
     * @var TeachingManager
     */
    private $teachingManager;
    /**
     * @var ImportManager
     */
    private $importManager;


    /**
     * HourApogeeMatching constructor.
     * @param TeachingManager $teachingManager
     * @param ImportManager $importManager
     */
    public function __construct(
        TeachingManager $teachingManager,
        ImportManager $importManager
    )
    {
        $this->teachingManager = $teachingManager;
        $this->importManager = $importManager;
    }

    /**
     * @return object
     */
    public function getNewEntity(): object
    {
        return $this->teachingManager->new();
    }

    /**
     * @return array|array[]
     */
    public function getBaseMatching(): array
    {

        return [
            'type' => ['name' => 'cod_typ_heu', 'required' => true, 'type'=> 'string', 'description' => "Type d'enseignement"],
            'hourlyVolume' => ['name' => 'nbr_heu_elp', 'required' => false, 'type'=> 'float', 'description' => "Volume horaire"],
        ];
    }

    /**
     * @return array|string[]
     */
    public function getLineIds(): array
    {
        return ['cod_typ_heu'];
    }

    /**
     * @param Course $course
     * @param string $property
     * @param string $name
     * @param string $type
     * @param $data
     * @param ReportLine $reportLine
     * @param Report $report
     * @return bool
     */
    public function manageSpecialCase($course, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool
    {
        return true;
    }


}