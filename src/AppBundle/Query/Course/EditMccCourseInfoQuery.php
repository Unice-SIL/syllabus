<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditMccCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditMccCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditMccCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var EditMccCourseInfoCommand
     */
    private $editMccCourseInfoCommand;

    /**
     * @var Security
     */
    private $security;

    /**
     * EditMccCourseInfoQuery constructor.
     * @param CourseInfoRepositoryInterface $courseInfoRepository
     * @param Security $security
     */
    public function __construct(
        CourseInfoRepositoryInterface $courseInfoRepository,
        Security $security
    )
    {
        $this->courseInfoRepository = $courseInfoRepository;
        $this->security = $security;
    }

    /**
     * @param EditMccCourseInfoCommand $editMccCourseInfoCommand
     * @return EditMccCourseInfoQuery
     */
    public function setEditMccCourseInfoCommand(EditMccCourseInfoCommand $editMccCourseInfoCommand): EditMccCourseInfoQuery
    {
        $this->editMccCourseInfoCommand = $editMccCourseInfoCommand;
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
            $courseInfo = $this->courseInfoRepository->find($this->editMccCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found.', $this->editMccCourseInfoCommand->getId()));
        }
        try{
            $courseInfo = $this->editMccCourseInfoCommand->filledEntity($courseInfo);
            $courseInfo->setModificationDate(new \DateTime())
                ->setLastUpdater($this->security->getUser());
            $this->courseInfoRepository->beginTransaction();
            $this->courseInfoRepository->update($courseInfo);
            $this->courseInfoRepository->commit();
        }catch (\Exception $e){
            $this->courseInfoRepository->rollback();
            throw $e;
        }
    }
}