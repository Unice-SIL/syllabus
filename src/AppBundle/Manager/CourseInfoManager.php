<?php

namespace AppBundle\Manager;

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
     * @var CourseInfo|null
     */
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
     * @param string|null $courseInfoSender
     * @param string|null $courseInfoRecipient
     * @param string $context
     * @param Report|null $report
     * @return Report
     * @throws \Exception
     */
    public function duplicate(?string $courseInfoSender, ?string $courseInfoRecipient, string $context, Report $report = null): Report
    {
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

        //=================================================Error Management=================================================
        if (!$report) {
            $report = ReportingHelper::createReport();
        }
        if (!$this->user) {
            $report->createMessage('Aucun utilisateur n\'est authentifié', ReportMessage::TYPE_DANGER);
        }

        if (count(self::$fieldsToDuplicate) <= 0) {
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
        if (!$courseInfoSender = $this->repository->findByEtbIdAndYear($courseInfoSender[0], $courseInfoSender[1])) {
            $reportLine->addComment('Le syllabus émetteur n\'éxiste pas.');
        }

        //todo: add addSelect to the request to get every relations if necessary (optimisation)
        if (!$courseInfoRecipient = $this->repository->findByEtbIdAndYear($courseInfoRecipient[0], $courseInfoRecipient[1])) {
            $reportLine->addComment('Le syllabus récépteur n\'éxiste pas.');
        }

        $report->addLineIfHasComments($reportLine);

        if ($report->hasMessages() or $report->hasLines()) {
            return $report;
        }
        //===============================================End Error Management============================================

        //===============================================Duplication Process============================================
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        foreach (self::$fieldsToDuplicate as $field) {

            $property = $field->getField();

            //Stocks data to duplicate in a variable
            $CourseInfoSenderData = $propertyAccessor->getValue($courseInfoSender, $property);


            // if the data to duplicate is a instance of collection we do a specific treatment (erase every old elements before duplicate the new ones)
            if ($CourseInfoSenderData instanceof Collection) {

               $this->duplicateCollectionProperty($CourseInfoSenderData, $courseInfoRecipient, $property, 'courseInfo');

                continue;
            }

            //if the data is not a instance of collection we can simply set it into the toCourseInfo $property
            $propertyAccessor->setValue($courseInfoRecipient, $property, $CourseInfoSenderData);

        }

        $courseInfoRecipient->setLastUpdater($this->user);
        $courseInfoRecipient->setModificationDate(new \DateTime());
        //==============================================End Duplication Process===========================================

        return $report;
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
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        //erases every current items
        foreach ($propertyAccessor->getValue($courseInfoRecipient, $property) as $item) {
            $this->em->remove($item);
        }

        //duplicates every items
        $collection = new ArrayCollection();
        foreach ($CourseInfoSenderData as $data){

            $dataClone = clone $data;

            $dataClone->setId(Uuid::uuid4());

            $propertyAccessor->setValue($dataClone, $inversedBy, $courseInfoRecipient);

            $collection->add($dataClone);
        }

        $propertyAccessor->setValue($courseInfoRecipient, $property, $collection);

    }

    public function importMcc(string $pathName)
    {
        //===================================Matching===================================
        $matching = [
            'mccWeight' => ['name' => 'coeff', 'type' => 'int'],
            'mccCapitalizable' => ['name' => 'capitalisable', 'type' => 'boolean'],
            'mccCompensable' => ['name' => 'compensable', 'type' => 'boolean'],
            'mccCtCoeffSession1' => ['name' => 'coeff_ct', 'type' => 'int'],
            'mccCcNbEvalSession1' => ['name' => 's1_cc_nb_eval', 'type' => 'int'],
            'mccCtNatSession1' => ['name' => 's1_ct_nature', 'type' => 'string'],
            'mccCtDurationSession1' => ['name' => 's1_ct_duree', 'type' => 'string'],
        ];

        $controlType = 'type_controle';
        $etbId = 'code_elp';
        $year = 'annee';
        //===================================End Matching===================================

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $csv = Reader::createFromPath($pathName);
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($delimiter = ';');

        $report = ReportingHelper::createReport();

        $appropriatesFields = array_map(function ($match) {return $match['name'];}, array_values($matching));
        $appropriatesFields = array_merge($appropriatesFields, [$controlType, $etbId, $year]);

        if(!AppHelper::sameArrays($csv->getHeader(), $appropriatesFields)) {
            $report->createMessage('Le format du tableau n\'est pas correct. Seuls les champs ' . implode('/', $appropriatesFields) . ' doivent être définit. Si les champs correspondend bien, vérifier que le délimiteur est bien "' . $delimiter . '"', ReportMessage::TYPE_DANGER);
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

                    if (in_array($record[$match['name']], [null, '']) and $property !== 'mccCtCoeffSession1') {
                        $reportLine->addComment('Le champ ' . $match['name'] . ' ne doit pas être vide');
                        continue;
                    }

                    $data = $record[$match['name']];

                    if ($match['type'] === 'boolean') {
                        switch (strtoupper($data)) {
                            case 'OUI':
                                $data = true;
                                break;
                            case 'NON':
                                $data = false;
                                break;
                            default:
                                $reportLine->addComment('La valeur du champ ' . $match['name'] . ' devrait être OUI ou NON. La valeur saisie est ' . $data);
                                continue;
                                break;
                        }
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
                                if (in_array($record[$match['name']], [null, '']) and $property) {
                                    $reportLine->addComment(
                                        'Le champ ' . $controlType . ' est du type ' . strtoupper($record[$controlType]) . ' mais aucun ' . $matching['mccCtCoeffSession1']['name'] . ' n\'a été renseigné.
                                    Impossible de répartir les coefficients entre CC et CT'
                                    );
                                    continue;
                                }
                                $coeff = (int) $data;
                                $courseInfo->setMccCcCoeffSession1(100 - $coeff);
                                $courseInfo->setMccCtCoeffSession1($coeff);
                                break;
                            default:
                                $reportLine->addComment('La valeur du champ ' . $match['name'] . ' devrait être CC, CT ou CC&CT. La valeur saisie est ' . $record[$controlType]);
                                continue;
                        }
                    }

                    if($match['type'] === 'int') {
                        if(!is_numeric($data)) {
                            $reportLine->addComment('La valeur du champ ' . $match['name'] . ' devrait être un nombre. La valeur saisie est ' . $data);
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
                    $this->em->detach($courseInfo);
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
                self::DUPLICATION_CONTEXTE_IMPORT,
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