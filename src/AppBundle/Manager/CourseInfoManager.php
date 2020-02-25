<?php

namespace AppBundle\Manager;

use AppBundle\Constant\Level;
use AppBundle\Constant\TeachingMode;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseInfoField;
use AppBundle\Entity\User;
use AppBundle\Entity\Year;
use AppBundle\Helper\AppHelper;
use AppBundle\Helper\ErrorManager;
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
class CourseInfoManager extends AbstractManager
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
     * @var User
     */
    private $user;
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;


    /**
     * CourseInfoManager constructor.
     * @param CourseInfoRepositoryInterface $repository
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     * @param ErrorManager $errorManager
     */
    public function __construct(
        CourseInfoRepositoryInterface $repository,
        EntityManagerInterface $em,
        TokenStorageInterface $tokenStorage,
        ErrorManager $errorManager
    )
    {
        parent::__construct($em, $errorManager);
        $this->repository = $repository;
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
        $courseInfo->setCreationDate(new \DateTime());

        return$courseInfo;
    }

    protected function getClass(): string
    {
        return CourseInfo::class;
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