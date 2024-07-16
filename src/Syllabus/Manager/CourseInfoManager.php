<?php

namespace App\Syllabus\Manager;

use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CourseInfoField;
use App\Syllabus\Entity\User;
use App\Syllabus\Helper\AppHelper;
use App\Syllabus\Helper\ErrorManager;
use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportingHelper;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Helper\Report\ReportMessage;
use App\Syllabus\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use League\Csv\Reader;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CourseInfoManager
 * @package App\Syllabus\Manager
 */
class CourseInfoManager extends AbstractManager
{
    const DUPLICATION_CONTEXTE_MANUALLY = 'manually';
    const DUPLICATION_CONTEXTE_AUTOMATIC = 'automatic';
    const DUPLICATION_CONTEXTE_IMPORT = 'import';

    const DUPLICATION_MANY_TO_MANY_FIELDS = [
        'levels',
        'domains',
        'languages',
        'periods',
        'campuses'
    ];

    private static array $fieldsToDuplicate = [];

    /**
     * @var CourseInfoDoctrineRepository
     */
    private CourseInfoDoctrineRepository $repository;

    /**
     * @var UserInterface|null
     */
    private ?UserInterface $user;

    /**
     * @var PropertyAccessor
     */
    private PropertyAccessor $propertyAccessor;

    /**
     * CourseInfoManager constructor.
     * @param CourseInfoDoctrineRepository $repository
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     * @param ErrorManager $errorManager
     */
    public function __construct(
        CourseInfoDoctrineRepository $repository,
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
     * @return CourseInfo
     */
    public function new(): CourseInfo
    {
        $courseInfo = new CourseInfo();
        $courseInfo->setCreationDate(new \DateTime());

        return$courseInfo;
    }

    /**
     * @param $id
     * @return CourseInfo|null
     */
    public function find($id): ?CourseInfo
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param CourseInfo $courseInfo
     */
    public function create(CourseInfo $courseInfo): void
    {
        $this->em->persist($courseInfo);
        $this->em->flush();
    }

    /**
     * @param CourseInfo $courseInfo
     */
    public function update(CourseInfo $courseInfo): void
    {
        $this->em->flush();
    }

    /**
     * @param CourseInfo $courseInfo
     */
    public function delete(CourseInfo $courseInfo): void
    {
        $this->em->remove($courseInfo);
        $this->em->flush();
    }

    /**
     * @return string
     */
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
     * @throws Exception
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

    /**
     * @param string $context
     */
    private function setFieldsToDuplicate(string $context): void
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

    /**
     * @param array $fieldsToDuplicate
     * @param CourseInfo $courseInfoSender
     * @param CourseInfo $courseInfoRecipient
     * @throws Exception
     */
    private function duplicationProcess(array $fieldsToDuplicate, CourseInfo $courseInfoSender, CourseInfo $courseInfoRecipient): void
    {
        foreach ($fieldsToDuplicate as $field) {
            $property = $field->getField();

            //Stocks data to duplicate in a variable
            $CourseInfoSenderData = $this->propertyAccessor->getValue($courseInfoSender, $property);

            // if the data to duplicate is a instance of collection we do a specific treatment (erase every old elements before duplicate the new ones)
            if ($CourseInfoSenderData instanceof Collection) {
                if (!in_array($property, self::DUPLICATION_MANY_TO_MANY_FIELDS)) {
                    $this->duplicateAndCloneCollectionProperty($CourseInfoSenderData, $courseInfoRecipient, $property, 'courseInfo');
                    continue;
                }
            }

            if ($CourseInfoSenderData instanceof File) {
                $this->duplicateFileProperty($CourseInfoSenderData, $courseInfoRecipient, $property);
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
     * @throws Exception
     */
    private function duplicateAndCloneCollectionProperty(Collection $CourseInfoSenderData, CourseInfo $courseInfoRecipient, string $property, string $inversedBy): void
    {
        //erases every current items
        foreach ($this->propertyAccessor->getValue($courseInfoRecipient, $property) as $item) {
            $this->em->remove($item);
        }

        //duplicates every items
        $collection = new ArrayCollection();
        foreach ($CourseInfoSenderData as $data){
            $data = clone $data;
            $data->setId(Uuid::uuid4());
            $this->propertyAccessor->setValue($data, $inversedBy, $courseInfoRecipient);
            $collection->add($data);
        }

        $this->propertyAccessor->setValue($courseInfoRecipient, $property, $collection);

    }

    /**
     * @param File $CourseInfoSenderData
     * @param CourseInfo $courseInfoRecipient
     * @param string $property
     */
    private function duplicateFileProperty(File $CourseInfoSenderData, CourseInfo $courseInfoRecipient, string $property): void
    {
        $filesystem = new Filesystem();
        $path = $CourseInfoSenderData->getPath();
        $filename = $CourseInfoSenderData->getFilename();
        $copiedFilename = md5(uniqid()).'.'.$CourseInfoSenderData->guessExtension();
        $filesystem->copy($path . '/' . $filename, $path . '/' . $copiedFilename);
        $this->propertyAccessor->setValue($courseInfoRecipient, $property, $copiedFilename);
    }

    /**
     * @param string $pathName
     * @return Report
     * @throws \League\Csv\Exception
     * @throws Exception
     */
    public function duplicateFromFile(string $pathName): Report
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