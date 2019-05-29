<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditInfosCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditInfosCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditInfosCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var EditInfosCourseInfoCommand
     */
    private $editInfosCourseInfoCommand;

    /**
     * @var Security
     */
    private $security;

    /**
     * EditInfosCourseInfoQuery constructor.
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
     * @param EditInfosCourseInfoCommand $editInfosCourseInfoCommand
     * @return EditInfosCourseInfoQuery
     */
    public function setEditInfosCourseInfoCommand(EditInfosCourseInfoCommand $editInfosCourseInfoCommand): EditInfosCourseInfoQuery
    {
        $this->editInfosCourseInfoCommand = $editInfosCourseInfoCommand;
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
            $courseInfo = $this->courseInfoRepository->find($this->editInfosCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found.', $this->editInfosCourseInfoCommand->getId()));
        }
        try{
            $courseInfo = $this->editInfosCourseInfoCommand->filledEntity($courseInfo);
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