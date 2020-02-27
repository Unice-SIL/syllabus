<?php


namespace AppBundle\Parser;

use AppBundle\Entity\Course;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Structure;
use AppBundle\Entity\Year;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Manager\CourseInfoManager;
use Doctrine\ORM\EntityManagerInterface;

class CourseInfoCsvParser extends AbstractCsvParser implements ParserInterface
{

    private $courseInfoManager;
    private $evaluationType;

    /**
     * CourseInfoCsvParser constructor.
     * @param EntityManagerInterface $em
     * @param CourseInfoManager $courseInfoManager
     */
    public function __construct(
        EntityManagerInterface $em,
        CourseInfoManager $courseInfoManager
    )
    {
        parent::__construct($em);
        $this->courseInfoManager = $courseInfoManager;
    }

    protected function getNewEntity(): object
    {
        return $this->courseInfoManager->createOne();
    }

    protected function getBaseMatching(): array
    {
        return [
            'course' => ['name' => 'code', 'required' => true, 'type'=> 'object', 'entity' => Course::class, 'findBy' => 'code', 'description' => "Code du cours du syllabus"],
            'year' => ['name' => 'year', 'required' => true, 'type'=> 'object', 'entity' => Year::class, 'findBy' => 'id', 'description' => "Année du syllabus"],
            'structure' => ['name' => 'structure', 'type' => 'object', 'entity' => Structure::class, 'findBy' => 'code'],
            'title',
            'ects' => ['type' => 'float'],
            'summary',
            'teachingMode',
            'teachingCmClass' => ['type' => 'float'],
            'teachingTdClass' => ['type' => 'float'],
            'teachingTpClass' => ['type' => 'float'],
            'teachingOtherClass' => ['type' => 'float'],
            'teachingOtherTypeClass',
            'teachingCmHybridClass' => ['type' => 'float'],
            'teachingTdHybridClass' => ['type' => 'float'],
            'teachingTpHybridClass' => ['type' => 'float'],
            'teachingOtherHybridClass' => ['type' => 'float'],
            'teachingOtherTypeHybridClass',
            'teachingCmHybridDist' => ['type' => 'float'],
            'teachingTdHybridDist' => ['type' => 'float'],
            'teachingOtherHybridDist' => ['type' => 'float'],
            'teachingOtherTypeHybridDistant',
            'teachingCmDist' => ['type' => 'float'],
            'teachingTdDist' => ['type' => 'float'],
            'teachingOtherDist' => ['type' => 'float'],
            'teachingOtherTypeDist',
            'mccWeight' => ['type' => 'int'],
            'mccCapitalizable' => ['type' => 'boolean'],
            'mccCompensable' => ['type' => 'boolean'],
            'evaluationType' => [ 'choices' => ['CC', 'CT', 'CC&CT']],
            'mccCtCoeffSession1' => ['type' => 'int'],
            'mccCcNbEvalSession1' => ['type' => 'int'],
            'mccCtNatSession1',
            'mccCtDurationSession1',
            'mccAdvice',
            'tutoring' => ['type' => 'boolean'],
            'tutoringTeacher' => ['type' => 'boolean'],
            'tutoringStudent' => ['type' => 'boolean'],
            'tutoringDescription',
            'educationalResources',
            'bibliographicResources',
            'agenda',
            'organization',
            'closingRemarks'
        ];
    }

    protected function getLineIds(): array
    {
        return ['code', 'year'];
    }

    /**
     * @param CourseInfo $entity
     * @param string $property
     * @param string $name
     * @param string $type
     * @param $data
     * @param ReportLine $reportLine
     * @return bool
     */
    protected function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine): bool
    {
        switch ($name) {
            case 'evaluationType':
                $this->evaluationType = $data;
                return false;
            case 'mccCtCoeffSession1':

                switch (strtoupper($this->evaluationType)) {
                    case 'CC':
                        $entity->setMccCcCoeffSession1(100);
                        $entity->setMccCtCoeffSession1(0);
                        return false;
                    case 'CT':
                        $entity->setMccCcCoeffSession1(0);
                        $entity->setMccCtCoeffSession1(100);
                        return false;
                    case 'CC&CT':
                        if (in_array($name, [null, '']) and $property) {
                            $reportLine->addComment(
                                "Le champ evaluationType est du type " . strtoupper($this->evaluationType) . " mais aucun {$name} n'a été renseigné.
                                    Impossible de répartir les coefficients entre CC et CT"
                            );
                            return false;
                        }
                        $coeff = $data;
                        $entity->setMccCcCoeffSession1(100 - $coeff);
                        $entity->setMccCtCoeffSession1($coeff);
                        return false;
                    default:
                        return false;
                }

        }

        return true;
    }


}