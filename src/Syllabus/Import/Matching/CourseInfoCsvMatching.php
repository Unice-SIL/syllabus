<?php


namespace App\Syllabus\Import\Matching;

use App\Syllabus\Constant\TeachingMode;
use App\Syllabus\Entity\Course;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\Structure;
use App\Syllabus\Entity\Year;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Manager\CourseInfoManager;
use Doctrine\ORM\EntityManagerInterface;

class CourseInfoCsvMatching extends AbstractMatching implements MatchingInterface
{

    private $courseInfoManager;
    private $evaluationType;
    /**
     * @var EntityManagerInterface
     */
    private $em;


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
        $this->em = $em;
        $this->courseInfoManager = $courseInfoManager;
    }

    public function getNewEntity(): object
    {
        return $this->courseInfoManager->new();
    }

    public function getBaseMatching(): array
    {
        $years = $this->em->getRepository(Year::class)->findAll();
        $years = array_map(function (Year $year){
            return $year->getId();
        }, $years);

        $structures = $this->em->getRepository(Structure::class)->findAll();
        $structures = array_map(function (Structure $structure){
            return $structure->getCode();
        }, $structures);

        return [
            'course' => ['name' => 'code', 'required' => true, 'type'=> 'object', 'entity' => Course::class, 'findBy' => 'code', 'description' => "Code du cours du syllabus"],
            'year' => ['name' => 'year', 'required' => true, 'type'=> 'object', 'entity' => Year::class, 'findBy' => 'id', 'choices' => $years, 'description' => "Année du syllabus"],
            'structure' => ['name' => 'structure', 'type' => 'object', 'entity' => Structure::class, 'findBy' => 'code', 'choices' => $structures, 'description' => "Code de la structure"],
            'title' => ['description' => "Titre du syllabus"],
            'ects' => ['type' => 'float', 'description' => "Nombre de crédit ECTS"],
            'summary' => ['description' => "Résumé du cours"],
            'teachingMode' => ['choices' => TeachingMode::TEACHING_MODES, 'description' => "Mode d'enseignement"],
            'teachingCmClass' => ['type' => 'float', 'description' => "Volume horaire CM pour le mode '".TeachingMode::IN_CLASS."'"],
            'teachingTdClass' => ['type' => 'float', 'description' => "Volume horaire TD pour le mode '".TeachingMode::IN_CLASS."'"],
            'teachingTpClass' => ['type' => 'float', 'description' => "Volume horaire TP pour le mode '".TeachingMode::IN_CLASS."'"],
            'teachingOtherClass' => ['type' => 'float', 'description' => "Volume horaire 'Autre' pour le mode '".TeachingMode::IN_CLASS."'"],
            'teachingOtherTypeClass' => ['description' => "Type de volume horaire 'Autre' pour le mode '".TeachingMode::IN_CLASS."'"],
            'teachingCmHybridClass' => ['type' => 'float', 'description' => "Volume horaire CM pour le mode '".TeachingMode::HYBRID."' en présentiel"],
            'teachingTdHybridClass' => ['type' => 'float', 'description' => "Volume horaire TD pour le mode '".TeachingMode::HYBRID."' en présentiel"],
            'teachingTpHybridClass' => ['type' => 'float', 'description' => "Volume horaire TP pour le mode '".TeachingMode::HYBRID."' en présentiel"],
            'teachingOtherHybridClass' => ['type' => 'float', 'description' => "Volume horaire 'Autre' pour le mode '".TeachingMode::HYBRID."' en présentiel"],
            'teachingOtherTypeHybridClass' => ['description' => "Type de volume horaire 'Autre' pour le mode '".TeachingMode::IN_CLASS."' en présentiel"],
            'teachingCmHybridDist' => ['type' => 'float', 'description' => "Volume horaire CM pour le mode '".TeachingMode::HYBRID."' à distance"],
            'teachingTdHybridDist' => ['type' => 'float', 'description' => "Volume horaire TD pour le mode '".TeachingMode::HYBRID."' à distance"],
            'teachingOtherHybridDist' => ['type' => 'float', 'description' => "Volume horaire 'Autre' pour le mode '".TeachingMode::HYBRID."' à distance"],
            'teachingOtherTypeHybridDistant' => ['description' => "Type de volume horaire 'Autre' pour le mode '".TeachingMode::HYBRID."' à distance"],
            'teachingCmDist' => ['type' => 'float', 'description' => "Volume horaire CM pour le mode '".TeachingMode::DIST."'"],
            'teachingTdDist' => ['type' => 'float', 'description' => "Volume horaire TD pour le mode '".TeachingMode::DIST."'"],
            'teachingOtherDist' => ['type' => 'float', 'description' => "Volume horaire 'Autre' pour le mode '".TeachingMode::DIST."'"],
            'teachingOtherTypeDist' => ['description' => "Type volume horaire 'Autre' pour le mode '".TeachingMode::DIST."'"],
            'mccWeight' => ['type' => 'int', 'description' => "Poids de l'ECUE dans l'UE"],
            'mccCapitalizable' => ['type' => 'boolean', 'choices' => ['OUI', 'NON', 'TRUE', 'FALSE'], 'description' => "Témoin UE/ECUE capitalisable"],
            'mccCompensable' => ['type' => 'boolean', 'choices' => ['OUI', 'NON', 'TRUE', 'FALSE'], 'description' => "Témoin UE/ECUE compensable"],
            'evaluationType' => [ 'choices' => ['CC', 'CT', 'CC&CT'], 'description' => "Type d'évaluation contrôle continu, terminal ou les deux"],
            'mccCtCoeffSession1' => ['type' => 'int', 'description' => "Coefficient Contrôle Continu pour la 1ère session (le coefficient du Contrôle Terminal est calculé automatiquement en fonction du type d'evaluation et du coefficient CC)"],
            'mccCcNbEvalSession1' => ['type' => 'int', 'description' => "Nombre d'évaluation(s) en contrôle continu pour la 1ère session"],
            'mccCtNatSession1' => ['description' => "Nature du contrôle terminal pour la 1ère session"],
            'mccCtDurationSession1' => ['description' => "Durée du contrôle terminal pour la 1ère session"],
            'mccAdvice' => ['description' => "Précisions sur les modalités d'évaluation"],
            'tutoring' => ['type' => 'boolean', 'description' => "Précisions sur les modalités d'évaluation"],
            'tutoringTeacher' => ['type' => 'boolean', 'description' => "Précisions sur les modalités d'évaluation"],
            'tutoringStudent' => ['type' => 'boolean', 'description' => "Précisions sur les modalités d'évaluation"],
            'tutoringDescription' => ['description' => "Précisions sur les modalités d'évaluation"],
            'educationalResources' => ['description' => "Resources pédagogiques"],
            'bibliographicResources' => ['description' => "Resources bibliographiques"],
            'agenda',
            'organization' => ['description' => "Organisation du cours"],
            'closingRemarks' => ['description' => "Mot de la fin"]
        ];
    }

    public function getLineIds(): array
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
     * @param Report $report
     * @return bool
     */
    public function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool
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