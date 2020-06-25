<?php


namespace AppBundle\Import\Matching;

use AppBundle\Entity\Course;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Import\Extractor\HourApogeeExtractor;
use AppBundle\Import\ImportManager;
use AppBundle\Manager\ CourseManager;

class CourseApogeeMatching extends AbstractMatching implements MatchingInterface
{

    private $courseManager;
    /**
     * @var ImportManager
     */
    private $importManager;
    /**
     * @var HourApogeeExtractor
     */
    private $hourApogeeExtractor;


    /**
     *  CourseApogeeParser constructor.
     * @param CourseManager $courseManager
     * @param ImportManager $importManager
     * @param HourApogeeExtractor $hourApogeeExtractor
     */
    public function __construct(
        CourseManager $courseManager,
        ImportManager $importManager,
        HourApogeeExtractor $hourApogeeExtractor
    )
    {
        $this->courseManager = $courseManager;
        $this->importManager = $importManager;
        $this->hourApogeeExtractor = $hourApogeeExtractor;
    }

    public function getNewEntity(): object
    {
        return $this->courseManager->new();
    }

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

    public function getLineIds(): array
    {
        return ['cod_elp'];
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
/*
        if ('code' === $property) {
            $this->hourApogeeExtractor->setCode($data);
            $hours = $this->importManager->extract($this->hourApogeeExtractor, $report);

            $course->setHours($hours);
        }
*/
        return true;
    }


}