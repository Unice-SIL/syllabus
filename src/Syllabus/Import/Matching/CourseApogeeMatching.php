<?php


namespace App\Syllabus\Import\Matching;

use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Import\ImportManager;
use App\Syllabus\Manager\CourseManager;

/**
 * Class CourseApogeeMatching
 * @package App\Syllabus\Import\Matching
 */
class CourseApogeeMatching extends AbstractMatching implements MatchingInterface
{
    /**
     * @var CourseManager
     */
    private $courseManager;
    /**
     * @var ImportManager
     */
    private $importManager;

    /**
     *  CourseApogeeParser constructor.
     * @param CourseManager $courseManager
     * @param ImportManager $importManager
     */
    public function __construct(
        CourseManager $courseManager,
        ImportManager $importManager
    )
    {
        $this->courseManager = $courseManager;
        $this->importManager = $importManager;
    }

    /**
     * @return object
     */
    public function getNewEntity(): object
    {
        return $this->courseManager->new();
    }

    /**
     * @return array|array[]
     */
    public function getBaseMatching(): array
    {

        return [
            'code' => ['name' => 'cod_elp', 'required' => true, 'type'=> 'string', 'description' => "Code du cours"],
            'title' => ['name' => 'lib_elp', 'required' => true, 'type'=> 'string', 'description' => "titre du cours"],
            'type' => ['name' => 'cod_nel', 'required' => true, 'type'=> 'string', 'description' => "Type du cours"],
            'ects' => ['name' => 'nbr_crd_elp', 'required' => false, 'type'=> 'float', 'description' => "Ects du cours"],
            'structureCode' => ['name' => 'cod_cmp', 'required' => true, 'type'=> 'string', 'description' => "Code de la structure du cours"],
        ];
    }

    /**
     * @return array|string[]
     */
    public function getLineIds(): array
    {
        return ['cod_elp'];
    }

    /**
     * @param $entity
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