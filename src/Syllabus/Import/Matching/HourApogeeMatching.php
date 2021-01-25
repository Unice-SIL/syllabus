<?php


namespace App\Syllabus\Import\Matching;

use App\Syllabus\Entity\Course;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Import\ImportManager;
use App\Syllabus\Manager\TeachingManager;

/**
 * Class HourApogeeMatching
 * @package App\Syllabus\Import\Matching
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