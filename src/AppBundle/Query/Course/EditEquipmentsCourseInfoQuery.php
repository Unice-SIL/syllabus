<?php

namespace AppBundle\Query\Course;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseResourceEquipment;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseResourceEquipmentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditEquipmentsCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditEquipmentsCourseInfoQuery
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var CourseResourceEquipmentRepositoryInterface
     */
    private $courseResourceEquipmentRepository;

    /**
     * @var Security
     */
    private $security;

    /**
     * EditEquipmentsCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param CourseResourceEquipmentRepositoryInterface $courseResourceEquipmentRepository
     * @param Security $security
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        CourseResourceEquipmentRepositoryInterface $courseResourceEquipmentRepository,
        Security $security
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->courseResourceEquipmentRepository = $courseResourceEquipmentRepository;
        $this->security = $security;
    }

    /**
     * @param CourseInfo $courseInfo
     * @param CourseInfo $originalCourseInfo
     * @throws \Exception
     */
    public function execute(CourseInfo $courseInfo, CourseInfo $originalCourseInfo): void
    {
        dump($courseInfo, $originalCourseInfo);
        try{
            $courseInfo->setModificationDate(new \DateTime())
                ->setLastUpdater($this->security->getUser());
            // Start transaction
            $this->courseInfoRepository->beginTransaction();

            /** @var CourseResourceEquipment $courseResourceEquipment */
            foreach ($courseInfo->getCourseResourceEquipments() as $offset => $courseResourceEquipment)
            {
                if (empty($courseResourceEquipment->getId()))
                {
                    $courseResourceEquipment->setId(Uuid::uuid4());
                }
            }

            // Loop on original course resource equipments to detect ResourceEquipments must be removed
            /** @var CourseResourceEquipment $courseResourceEquipment */
            foreach ($originalCourseInfo as $courseResourceEquipment)
            {
                if (!$courseInfo->getCourseResourceEquipments()->contains($courseResourceEquipment))
                {
                    $this->courseResourceEquipmentRepository->delete($courseResourceEquipment);
                }
            }

            // Update course infos
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}