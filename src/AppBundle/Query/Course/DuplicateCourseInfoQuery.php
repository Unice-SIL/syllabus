<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\PublishCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Year;
use AppBundle\Exception\CourseInfoAlreadyExistException;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Security;

/**
 * Class DuplicateCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class DuplicateCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;

    /**
     * @var CourseInfo
     */
    private $courseInfo;

    /**
     * @var Year
     */
    private $year;


    /**
     * DuplicateCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param FileUploaderHelper $fileUploaderHelper
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        FileUploaderHelper $fileUploaderHelper
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->fileUploaderHelper = $fileUploaderHelper;
    }

    /**
     * @param CourseInfo $courseInfo
     * @return DuplicateCourseInfoQuery
     */
    public function setCourseInfo(CourseInfo $courseInfo): DuplicateCourseInfoQuery
    {
        $this->courseInfo = $courseInfo;

        return $this;
    }

    /**
     * @param Year $year
     * @return DuplicateCourseInfoQuery
     */
    public function setYear(Year $year): DuplicateCourseInfoQuery
    {
        $this->year = $year;

        return $this;
    }


    /**
     * @throws CourseInfoNotFoundException
     * @throws \Exception
     */
    public function execute(): void
    {
        try {
            $courseInfo = $this->courseInfoRepository->findByEtbIdAndYear($this->courseInfo->getCourse()->getEtbId(), $this->year->getId());
            if(!is_null($courseInfo))
            {
                throw new CourseInfoAlreadyExistException();
            }
            $courseInfo = clone $this->courseInfo;
            $courseInfo->setId(Uuid::uuid4())
                ->setYear($this->year)
                ->setLastUpdater(null)
                ->setPublisher(null)
                ->setCreationDate(new \DateTime())
                ->setModificationDate(null)
                ->setPublicationDate(null)
                ->setTemPresentationTabValid(false)
                ->setTemActivitiesTabValid(false)
                ->setTemObjectivesTabValid(false)
                ->setTemMccTabValid(false)
                ->setTemEquipmentsTabValid(false)
                ->setTemInfosTabValid(false)
                ->setTemClosingRemarksTabValid(false);

            if($courseInfo->getImage())
            {
                $courseInfo->setImage($this->fileUploaderHelper->copy($courseInfo->getImage()));
            }

            $this->courseInfoRepository->create($courseInfo);
        }catch (\Exception $e){
            throw $e;
        }
    }
}