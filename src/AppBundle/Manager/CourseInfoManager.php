<?php

namespace AppBundle\Manager;

use AppBundle\Constant\Level;
use AppBundle\Constant\TeachingMode;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseInfoField;
use AppBundle\Entity\User;
use AppBundle\Entity\Year;
use AppBundle\Helper\AppHelper;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Helper\Report\ReportMessage;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CourseInfoManager
 * @package AppBundle\Manager
 */
class CourseInfoManager
{
    const DUPLICATION_CONTEXTE_MANUALLY = 'manually';
    const DUPLICATION_CONTEXTE_AUTOMATIC = 'automatic';
    const DUPLICATION_CONTEXTE_IMPORT = 'import';

    private static $fieldsToDuplicate = [];
    private static $yearsConcernedByImport;

    /**
     * @var CourseInfoRepositoryInterface
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
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CourseInfoManager constructor.
     * @param CourseInfoRepositoryInterface $repository
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     * @param ValidatorInterface $validator
     */
    public function __construct(
        CourseInfoRepositoryInterface $repository,
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        ValidatorInterface $validator
    )
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->validator = $validator;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();

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

    public function createOne()
    {
        $courseInfo = new CourseInfo();
        $courseInfo->setId(Uuid::uuid4());
        $courseInfo->setCreationDate(new \DateTime());

        return$courseInfo;
    }

    /**
     * @param string|null $courseInfoSender
     * @param string|null $courseInfoRecipient
     * @param string $context
     * @param Report|null $report
     * @return Report
     * @throws \Exception
     */
    public function duplicate(?string $courseInfoSender, ?string $courseInfoRecipient, string $context, Report $report = null): Report
    {
        $this->setFieldsToDuplicate($context);

        //=================================================Error Management=================================================
        if (!$report) {
            $report = ReportingHelper::createReport();
        }

        if (count(self::$fieldsToDuplicate[$context]) <= 0) {
            $report->createMessage('Aucun champ n\'est activé pour import.', ReportMessage::TYPE_DANGER);
        }

        $courseInfoSender = explode('__UNION__', $courseInfoSender);
        $courseInfoRecipient = explode('__UNION__', $courseInfoRecipient);

        if (!isset($courseInfoSender[1]) or !isset($courseInfoRecipient[1])) {
            $report->createMessage('Les informations saisies ne sont pas valides', ReportMessage::TYPE_DANGER);
            return $report;
        }

        $reportLine = new ReportLine('Depuis ' . $courseInfoSender[0] . '-' . $courseInfoSender[1] . ' vers ' . $courseInfoRecipient[0] . '-' . $courseInfoRecipient[1]);

        if ($courseInfoSender === $courseInfoRecipient ) {
            $reportLine->addComment('Le syllabus émetteur ne peut pas être le même que le syllabus récepteur.');
        }

        //todo: add addSelect to the request to get every relations if necessary (optimisation)
        if (!$courseInfoSender = $this->repository->findByCodeAndYear($courseInfoSender[0], $courseInfoSender[1])) {
            $reportLine->addComment('Le syllabus émetteur n\'éxiste pas.');
        }

        //todo: add addSelect to the request to get every relations if necessary (optimisation)
        if (!$courseInfoRecipient = $this->repository->findByCodeAndYear($courseInfoRecipient[0], $courseInfoRecipient[1])) {
            $reportLine->addComment('Le syllabus récépteur n\'éxiste pas.');
        }

        $report->addLineIfHasComments($reportLine);

        if ($report->hasMessages() or $report->hasLines()) {
            return $report;
        }
        //===============================================End Error Management============================================

        //===============================================Duplication Process============================================
        $this->duplicationProcess(self::$fieldsToDuplicate[$context], $courseInfoSender, $courseInfoRecipient);
        //==============================================End Duplication Process===========================================

        return $report;
    }

    public function createOrUpdate(CourseInfo $courseInfoData, array $options = [])
    {

        $options = array_merge([
            'flush' => false,
            'validation_groups' => null
        ], $options);

        //If we're looping on this function it's no necessary to get $year from the database every time (we put them in a static property cache)
        if (!self::$yearsConcernedByImport) {
            self::$yearsConcernedByImport = $this->em->getRepository(Year::class)->findByImport(true);
        }

        foreach (self::$yearsConcernedByImport as $year) {

            if (!$courseInfo = $this->repository->findByCodeAndYear($courseInfoData->getCourse()->getCode(), $year->getId())) {
                $courseInfo = new CourseInfo();
                $courseInfo->setCourse($courseInfoData->getCourse());
                $courseInfo->setYear($year);
                $this->em->persist($courseInfo);
            }

            $this->setFieldsToDuplicate(self::DUPLICATION_CONTEXTE_IMPORT);

            $this->duplicationProcess(self::$fieldsToDuplicate[self::DUPLICATION_CONTEXTE_IMPORT], $courseInfoData, $courseInfo);

            $violations = $this->validator->validate($courseInfo, null, $options['validation_groups']);

            if (count($violations) > 0) {
                $message = 'Cannot validate the data.' . "\n";
                foreach ($violations as $violation) {
                    $error = $violation->getPropertyPath() . ' => ' . $violation->getMessage() . "\n";
                    $message .= ' ' . $error;
                }
                throw new InvalidResourceException($message);
            }

            if (true === $options['flush']) {
                $this->em->flush();
            }

        }

    }

    private function setFieldsToDuplicate(string $context)
    {
        //If we're looping on this function it's no necessary to get fields from the database every time (we put them in a static property cache)
        if (!isset(self::$fieldsToDuplicate[$context])) {
            switch ($context) {
                case self::DUPLICATION_CONTEXTE_AUTOMATIC:
                    self::$fieldsToDuplicate[$context] = $this->em->getRepository(CourseInfoField::class)->findByAutomaticDuplication(true);
                    break;
                default:
                    self::$fieldsToDuplicate[$context] = $this->em->getRepository(CourseInfoField::class)->findByManuallyDuplication(true);
                    break;
            }
        }
    }


    private function duplicationProcess(array $fieldsToDuplicate, CourseInfo $courseInfoSender, CourseInfo $courseInfoRecipient)
    {

        foreach ($fieldsToDuplicate as $field) {

            $property = $field->getField();

            //Stocks data to duplicate in a variable
            $CourseInfoSenderData = $this->propertyAccessor->getValue($courseInfoSender, $property);

            // if the data to duplicate is a instance of collection we do a specific treatment (erase every old elements before duplicate the new ones)
            if ($CourseInfoSenderData instanceof Collection) {

                $this->duplicateCollectionProperty($CourseInfoSenderData, $courseInfoRecipient, $property, 'courseInfo');

                continue;
            }

            //if the data is not a instance of collection we can simply set it into the toCourseInfo $property
            $this->propertyAccessor->setValue($courseInfoRecipient, $property, $CourseInfoSenderData);

        }

        $courseInfoRecipient->setLastUpdater($this->user);
        $courseInfoRecipient->setModificationDate(new \DateTime());
    }

    /**
     * @param Collection $CourseInfoSenderData
     * @param CourseInfo $courseInfoRecipient
     * @param string $property
     * @param string $inversedBy
     * @throws \Exception
     */
    private function duplicateCollectionProperty(Collection $CourseInfoSenderData, CourseInfo $courseInfoRecipient, string $property, string $inversedBy)
    {

        //erases every current items
        foreach ($this->propertyAccessor->getValue($courseInfoRecipient, $property) as $item) {
            $this->em->remove($item);
        }

        //duplicates every items
        $collection = new ArrayCollection();
        foreach ($CourseInfoSenderData as $data){

            $dataClone = clone $data;

            $dataClone->setId(Uuid::uuid4());

            $this->propertyAccessor->setValue($dataClone, $inversedBy, $courseInfoRecipient);

            $collection->add($dataClone);
        }

        $this->propertyAccessor->setValue($courseInfoRecipient, $property, $collection);

    }

    /**
     * @param string $pathName
     * @return Report
     * @throws \League\Csv\Exception
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
        $code = 'code';
        $year = 'year';
        //===================================End Matching===================================

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
        $appropriatesFields = array_merge($appropriatesFields, [$controlType, $code, $year]);

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

                $lineId = $record[$code] . '-' . $record[$year];
                $reportLine = new ReportLine($lineId);

                $courseInfo = $this->repository->findByCodeAndYear($record[$code], $record[$year]);

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
                            case 'TRUE':
                            case '1':
                                $data = true;
                                break;
                            case 'NON':
                            case 'FALSE':
                            case '0':
                                $data = false;
                                break;
                            default:
                                $reportLine->addComment("La valeur du champ {$name} devrait être OUI ou NON. La valeur saisie est {$data}.");
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
                                break;
                            case 'CT':
                                $courseInfo->setMccCcCoeffSession1(0);
                                $courseInfo->setMccCtCoeffSession1(100);
                                break;
                            case 'CC&CT':
                                if (in_array($record[$name], [null, '']) and $property) {
                                    $reportLine->addComment(
                                        "Le champ {$controlType} est du type " . strtoupper($record[$controlType]) . " mais aucun {$matching['mccCtCoeffSession1']['name'] } n'a été renseigné.
                                    Impossible de répartir les coefficients entre CC et CT"
                                    );
                                    break;
                                }
                                $coeff = (int) $data;
                                $courseInfo->setMccCcCoeffSession1(100 - $coeff);
                                $courseInfo->setMccCtCoeffSession1($coeff);
                                break;
                            default:
                                $reportLine->addComment("La valeur du champ {$name} devrait être CC, CT ou CC&CT. La valeur saisie est {$record[$controlType]}");
                                break;
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
                        $this->propertyAccessor->setValue($courseInfo, $property, $data);
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


        if ($report->hasMessages()) {
            return $report;
        }

        $break = false;
        foreach ($csv as $record) {

            $result = $this->duplicate(
                $record['cod_elp_exp'] . '__UNION__' .  $record['annee_exp'],
                $record['cod_elp_dest'] . '__UNION__' . $record['annee_dest'],
                self::DUPLICATION_CONTEXTE_AUTOMATIC,
                $report
            );

            if ($report->hasMessages()) {
                $break = true;
                break;
            }

        }

        if (!$break) {
            $report->finishReport(iterator_count($csv));
        }

        return $report;
    }

}