<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditEquipmentsCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use AppBundle\Repository\CourseResourceEquipmentRepositoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditEquipmentsCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditEquipmentsCourseInfoQuery implements QueryInterface
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
     * @var EditEquipmentsCourseInfoCommand
     */
    private $editEquipmentsCourseInfoCommand;

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
     * @param EditEquipmentsCourseInfoCommand $editEquipmentsCourseInfoCommand
     * @return EditEquipmentsCourseInfoQuery
     */
    public function setEditEquipmentsCourseInfoCommand(EditEquipmentsCourseInfoCommand $editEquipmentsCourseInfoCommand): EditEquipmentsCourseInfoQuery
    {
        $this->editEquipmentsCourseInfoCommand = $editEquipmentsCourseInfoCommand;
        return $this;
    }

    /**
     * @throws CourseInfoNotFoundException
     * @throws \Exception
     */
    public function execute(): void
    {
        try {
            // Find CourseInfo
            $courseInfo = $this->courseInfoRepository->find($this->editEquipmentsCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found.', $this->editEquipmentsCourseInfoCommand->getId()));
        }
        try{
            // Keep an original course equipments copy
            $originalCourseResourceEquipments = $courseInfo->getCourseResourceEquipments();
            // Fill course info with new values
            $courseInfo = $this->editEquipmentsCourseInfoCommand->filledEntity($courseInfo);
            $courseInfo->setModificationDate(new \DateTime())
                ->setLastUpdater($this->security->getUser());
            // Start transaction
            $this->courseInfoRepository->beginTransaction();
            // Loop on original course resource equipments to detect Resourceequipments must be removed
            foreach ($originalCourseResourceEquipments as $courseResourceEquipment) {
                if (!$courseInfo->getCourseResourceEquipments()->contains($courseResourceEquipment)) {
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