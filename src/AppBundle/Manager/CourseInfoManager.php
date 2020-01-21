<?php

namespace AppBundle\Manager;

use AppBundle\Constant\Level;
use AppBundle\Constant\TeachingMode;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseInfoField;
use AppBundle\Entity\User;
use AppBundle\Helper\AppHelper;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Helper\Report\ReportMessage;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CourseInfoManager
 * @package AppBundle\Manager
 */
class CourseInfoManager
{
    const DUPLICATION_CONTEXTE_MANUALLY = 'manually';
    const DUPLICATION_CONTEXTE_IMPORT = 'import';
    /**
     * @var CourseInfo|object|null
     */
    private static $fromCourseInfo;
    /**
     * @var CourseInfo|object|null
     */
    private static $toCourseInfo;

    private static $fieldsToDuplicate;
    /**
     * @var CourseInfoDoctrineRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var User
     */
    private $user;

    /**
     * CourseInfoManager constructor.
     * @param CourseInfoRepositoryInterface $repository
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        CourseInfoRepositoryInterface $repository,
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->repository = $repository;
        $this->em = $em;

        if ($token = $tokenStorage->getToken()) {
            $this->user = $token->getUser();
        }
    }

    /**
     * @param $id
     * @return CourseInfo|null
     * @throws \Exception
     */
    public function find($id): ?CourseInfo
    {
        $courseInfo = $this->repository->find($id);
        return $courseInfo;
    }

    /**
     * @param CourseInfo $courseInfo
     * @throws \Exception
     */
    public function create(CourseInfo $courseInfo)
    {
        $courseInfo->setId(Uuid::uuid4());
        $this->repository->create($courseInfo);
    }

    /**
     * @param CourseInfo $courseInfo
     * @throws \Exception
     */
    public function update(CourseInfo $courseInfo)
    {
        $this->repository->update($courseInfo);
    }

    /**
     * @param string $idFromCourseInfo
     * @param string $idToCourseInfo
     * @param string $context
     * @return array
     * @throws \Exception
     */
    public function duplicate(?string $idFromCourseInfo, ?string $idToCourseInfo, string $context)
    {
        $errors = [];
        if (!$this->user) {
            $errors['messages'][] = 'Aucun utilisateur n\'est authentifié';
        }

        //If we're looping on this function it's no necessary to get fields from the database every time (we put them in a static property cache)
        if (!self::$fieldsToDuplicate) {
            switch ($context) {
                case self::DUPLICATION_CONTEXTE_IMPORT:
                    self::$fieldsToDuplicate = $this->em->getRepository(CourseInfoField::class)->findByAutomaticDuplication(true);
                    break;
                default:
                    self::$fieldsToDuplicate = $this->em->getRepository(CourseInfoField::class)->findByManuallyDuplication(true);
                    break;
            }
        }

        if (count(self::$fieldsToDuplicate) <= 0) {
            $errors['messages'][] = 'Aucun champ n\'est activé pour import.';
        }

        $errors = $this->testsIfErrorsAndInitializesStaticProperties($idFromCourseInfo, $idToCourseInfo, $errors);

        if (count($errors) > 0) {
            return $errors;
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach (self::$fieldsToDuplicate as $field) {

            $property = $field->getField();

            //Stocks data to duplicate in a variable
            $fromCourseInfoData = $propertyAccessor->getValue(self::$fromCourseInfo, $property);


            // if the data to duplicate is a instance of collection we do a specific treatment (erase every old elements before duplicate the new ones)
            if ($fromCourseInfoData instanceof Collection) {

               $this->duplicateCollectionProperty($fromCourseInfoData, $property, 'courseInfo');

                continue;
            }

            //if the data is not a instance of collection we can simply set it into the toCourseInfo $property
            $propertyAccessor->setValue(self::$toCourseInfo, $property, $fromCourseInfoData);

        }

        self::$toCourseInfo->setLastUpdater($this->user);
        self::$toCourseInfo->setModificationDate(new \DateTime());

        return $errors;
    }

    /**
     * @param string $fromCourseInfoId
     * @param string $toCourseInfoId
     * @param array $errors
     * @return array
     */
    private function testsIfErrorsAndInitializesStaticProperties (?string $fromCourseInfoId, ?string $toCourseInfoId, array $errors = [])
    {

        if ($fromCourseInfoId === $toCourseInfoId ) {
            $errors['line']['comments'][] = 'Le syllabus émetteur ne peut pas être le même que le syllabus récepteur.';
        }

        $fromCourseInfoId = explode('__UNION__', $fromCourseInfoId);
        //todo: add addSelect to the request to get every relations if necessary (optimisation)
        self::$fromCourseInfo = $this->repository->findByEtbIdAndYear($fromCourseInfoId[0], $fromCourseInfoId[1]);
        if (!self::$fromCourseInfo) {
            $errors['line']['comments'][] = 'Le syllabus émetteur n\'éxiste pas.';
        }

        $toCourseInfoId = explode('__UNION__', $toCourseInfoId);
        //todo: add addSelect to the request to get every relations if necessary (optimisation)
        self::$toCourseInfo = $this->repository->findByEtbIdAndYear($toCourseInfoId[0], $toCourseInfoId[1]);

        if (!self::$toCourseInfo) {
            $errors['line']['comments'][] = 'Le syllabus récépteur n\'éxiste pas.';
        }

        return $errors;

    }

    /**
     * @param Collection $fromCourseInfoData
     * @param string $property
     * @param string $inversedBy
     * @throws \Exception
     */
    private function duplicateCollectionProperty(Collection $fromCourseInfoData, string $property, string $inversedBy)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        //erases every current items
        foreach ($propertyAccessor->getValue(self::$toCourseInfo, $property) as $item) {
            $this->em->remove($item);
        }

        //duplicates every items
        $collection = new ArrayCollection();
        foreach ($fromCourseInfoData as $data){

            $dataClone = clone $data;

            $dataClone->setId(Uuid::uuid4());

            $propertyAccessor->setValue($dataClone, $inversedBy, self::$toCourseInfo);

            $collection->add($dataClone);
        }

        $propertyAccessor->setValue(self::$toCourseInfo, $property, $collection);

    }

    /**
     * @param string $pathName
     * @return Report
     */
    public function importMcc(string $pathName)
    {
        //===================================Matching===================================
        /**
         * example : [
         *     'title' => [
         *          'name' => 'Titre' // optionnal, by default the name is the array key
         *          'type' => 'string' // optionnal by default is string
         *      ]
         * ]
         */
        $matching = [
            'title',
            'ects' => ['type' => 'float'],
            'level',
            'languages',
            'domain',
            'summary',
            'period',
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

        $controlType = 'evaluationType';
        $etbId = 'etbId';
        $year = 'year';
        //===================================End Matching===================================

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $csv = Reader::createFromPath($pathName);
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($delimiter = ';');

        $report = ReportingHelper::createReport();

        $appropriatesFields = array_map(function ($match, $property) {
            $name = $match;
            if(is_array($match))
            {
                $name  = array_key_exists('name', $match)? $match['name'] : $property;
            }
            return $name;
        }, $matching, array_keys($matching));
        $appropriatesFields = array_merge($appropriatesFields, [$controlType, $etbId, $year]);

        //if(!AppHelper::sameArrays($csv->getHeader(), $appropriatesFields)) {
        if(!is_array($csv->getHeader()) or !is_array($appropriatesFields))
        {
            $report->createMessage('Le format du tableau n\'est pas correct. Seuls les champs ' . implode('/', $appropriatesFields) . ' doivent être définit. Si les champs correspondend bien, vérifier que le délimiteur est bien "' . $delimiter . '"', ReportMessage::TYPE_DANGER);
        }

        if(count($unknowFields = array_diff($csv->getHeader(), $appropriatesFields)) > 0)
        {
            $report->createMessage("Les champs suivants ne font pas partis de la liste des champs autorisés : ".implode($unknowFields).". Sont autorisés les champs ".implode($appropriatesFields), ReportMessage::TYPE_DANGER);
        }

        if ($report->getMessages()->isEmpty()) {

            foreach ($csv as $offset => $record) {

                $lineId = $record[$etbId] . '-' . $record[$year];
                $reportLine = new ReportLine($lineId);

                $courseInfo = $this->repository->findByEtbIdAndYear($record[$etbId], $record[$year]);

                if (!$courseInfo) {
                    $reportLine->addComment('Ce syllabus n\'existe pas');
                    continue;
                }

                foreach ($matching as $property => $match) {
                    $name = $match;
                    $type = 'string';
                    if(is_array($match))
                    {
                        $name  = array_key_exists('name', $match)? $match['name'] : $property;
                        $type = array_key_exists('type', $match)? $match['type'] : $type;
                    }else{
                        $property = $name;
                    }

                    if(!array_key_exists($name, $record))
                    {
                        continue;
                    }

                    if (in_array($record[$name], [null, '']) and $property !== 'mccCtCoeffSession1') {
                        $reportLine->addComment("Le champ {$name} ne doit pas être vide");
                        continue;
                    }

                    $data = $record[$name];

                    if ($type === 'boolean') {
                        switch (strtoupper($data)) {
                            case 'OUI':
                                $data = true;
                                break;
                            case 'TRUE':
                                $data = true;
                                break;
                            case '1':
                                $data = true;
                                break;
                            case 'NON':
                                $data = false;
                                break;
                            case 'FALSE':
                                $data = false;
                                break;
                            case '0':
                                $data = false;
                                break;
                            default:
                                $reportLine->addComment("La valeur du champ {$name} devrait être OUI ou NON. La valeur saisie est {$data}.");
                                continue;
                                break;
                        }
                    }

                    // Special case if the property check is level
                    if ($property === 'level' && !in_array($record[$property], Level::CHOICES)) {
                        $reportLine->addComment("Le champ {$property} doit contenir une des valeurs suivante: ".implode(', ', Level::CHOICES));
                    }

                    // Special case if the property check is level
                    if ($property === 'teachingMode' && !in_array($record[$property], TeachingMode::CHOICES)) {
                        $reportLine->addComment("Le champ {$property} doit contenir une des valeurs suivante: ".implode(', ', TeachingMode::CHOICES));
                    }

                    //Special case if the property check is mccCtCoeffSession1
                    if ($property === 'mccCtCoeffSession1') {
                        switch (strtoupper($record[$controlType])) {
                            case 'CC':
                                $courseInfo->setMccCcCoeffSession1(100);
                                $courseInfo->setMccCtCoeffSession1(0);
                                continue;
                            case 'CT':
                                $courseInfo->setMccCcCoeffSession1(0);
                                $courseInfo->setMccCtCoeffSession1(100);
                                continue;
                            case 'CC&CT':
                                if (in_array($record[$name], [null, '']) and $property) {
                                    $reportLine->addComment(
                                        "Le champ {$controlType} est du type " . strtoupper($record[$controlType]) . " mais aucun {$matching['mccCtCoeffSession1']['name'] } n'a été renseigné.
                                    Impossible de répartir les coefficients entre CC et CT"
                                    );
                                    continue;
                                }
                                $coeff = (int) $data;
                                $courseInfo->setMccCcCoeffSession1(100 - $coeff);
                                $courseInfo->setMccCtCoeffSession1($coeff);
                                break;
                            default:
                                $reportLine->addComment("La valeur du champ {$name} devrait être CC, CT ou CC&CT. La valeur saisie est {$record[$controlType]}");
                                continue;
                        }
                    }

                    if($type === 'int') {
                        if(!is_numeric($data)) {
                            $reportLine->addComment("La valeur du champ {$name} devrait être un nombre. La valeur saisie est {$data}");
                            continue;
                        }
                        $data = (int) $data;
                    }

                    try {
                        $propertyAccessor->setValue($courseInfo, $property, $data);
                    }catch (\Exception $e) {
                        $reportLine->addComment('Un problème inconnu est survenu.');
                    }

                }

                if ($report->addLineIfHasComments($reportLine)) {
                    $this->em->getUnitOfWork()->removeFromIdentityMap($courseInfo);
                    continue;
                }

            }

            $report->finishReport(iterator_count($csv));

        }

        return $report;
    }

    /**
     * @param string $pathName
     * @return Report
     */
    public function duplicateFromFile(string $pathName)
    {
        $csv = Reader::createFromPath($pathName);
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($delimiter = ';');

        $report = ReportingHelper::createReport();

        $appropriatesFields = ['cod_elp_exp', 'annee_exp', 'cod_elp_dest', 'annee_dest'];

        if(!AppHelper::sameArrays($csv->getHeader(), $appropriatesFields)) {
            $report->createMessage('Le format du tableau n\'est pas correct. Seuls les champs ' . implode('/', $appropriatesFields) . ' doivent être définit. Si les champs correspondend bien, vérifier que le délimiteur est bien "' . $delimiter . '"', ReportMessage::TYPE_DANGER);
        }

        if ($report->getMessages()->isEmpty()) {
            $break = false;
            foreach ($csv as $record) {
                $reportLine = new ReportLine('Depuis ' . $record['cod_elp_exp'] . '-' . $record['annee_exp'] . ' vers ' . $record['cod_elp_dest'] . '-' . $record['annee_dest']);

                $idFromCourseInfo = $record['cod_elp_exp'] . '__UNION__' .  $record['annee_exp'];
                $idToCourseInfo = $record['cod_elp_dest'] . '__UNION__' . $record['annee_dest'];

                $result = $this->duplicate(
                    $idFromCourseInfo,
                    $idToCourseInfo,
                    self::DUPLICATION_CONTEXTE_IMPORT
                );

                if (isset($result['messages'])) {
                    foreach ($result['messages'] as $message ) {
                        $report->createMessage($message, ReportMessage::TYPE_DANGER);
                        $break = true;
                    }
                }

                if ($break) {
                    break;
                }

                if (isset($result['line']['comments'])) {
                    foreach ($result['line']['comments'] as $comment ) {
                        $reportLine->addComment($comment);
                    }
                }

                $report->addLineIfHasComments($reportLine);

            }
        }

        if (!$break) {
            $report->finishReport(iterator_count($csv));
        }

        return $report;
    }

}