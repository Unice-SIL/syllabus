<?php

namespace AppBundle\Manager;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseInfoField;
use AppBundle\Entity\User;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Inflector\Inflector;
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
    public function duplicate(string $idFromCourseInfo, string $idToCourseInfo, string $context)
    {

        $errors = $this->testsIfErrorsAndInitializesStaticProperties($idFromCourseInfo, $idToCourseInfo, $context);

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
     * @param string $context
     * @return array
     */
    private function testsIfErrorsAndInitializesStaticProperties (string $fromCourseInfoId, string $toCourseInfoId, string $context)
    {
        $errors = [];

        if (!$this->user) {
            $errors[] = 'Aucun utilisateur n\'est authentifié';
        }

        if ($fromCourseInfoId === $toCourseInfoId) {
            $errors[] = 'Le syllabus émetteur ne peut pas être le même que le syllabus récepteur.';
        }

        //todo: add addSelect to the request to get every relations if necessary (optimisation)
        self::$fromCourseInfo = $this->em->getRepository(CourseInfo::class)->findOneBy(['id' => $fromCourseInfoId]);
        if (!self::$fromCourseInfo) {
            $errors[] = 'Le syllabus émetteur n\'éxiste pas.';
        }

        //todo: add addSelect to the request to get every relations if necessary (optimisation)
        self::$toCourseInfo = $this->em->getRepository(CourseInfo::class)->findOneBy(['id' => $toCourseInfoId]);

        if (!self::$toCourseInfo) {
            $errors[] = 'Le syllabus récépteur n\'éxiste pas.';
        }

        //If we're looping on this function it's no necessary to get fields from the database every time (we put them in a static property cache)
        if (!self::$fieldsToDuplicate) {
            switch ($context) {
                case self::DUPLICATION_CONTEXTE_IMPORT:
                    //self::$fieldsToDuplicate = $this->em->getRepository(ChooseYourRepository::class)->findByImport(true);
                    break;
                default:
                    self::$fieldsToDuplicate = $this->em->getRepository(CourseInfoField::class)->findByManuallyDuplication(true);
                    break;
            }
        }

        if (count(self::$fieldsToDuplicate) <= 0) {
            $errors[] = 'Aucun champ n\'est activé pour import.';
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
}