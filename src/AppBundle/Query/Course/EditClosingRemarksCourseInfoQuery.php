<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditClosingRemarksCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditClosingRemarksCourseInfoQuery implements QueryInterface
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

    /**
     * @var EditClosingRemarksCourseInfoCommand
     */
    private $editClosingRemarksCourseInfoCommand;

    /**
     * @var Security
     */
    private $security;

    /**
     * EditClosingRemarksCourseInfoQuery constructor.
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
     * @param EditClosingRemarksCourseInfoCommand $editClosingRemarksCourseInfoCommand
     * @return EditClosingRemarksCourseInfoQuery
     */
    public function setEditClosingRemarksCourseInfoCommand(EditClosingRemarksCourseInfoCommand $editClosingRemarksCourseInfoCommand): EditClosingRemarksCourseInfoQuery
    {
        $this->editClosingRemarksCourseInfoCommand = $editClosingRemarksCourseInfoCommand;
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
            $courseInfo = $this->courseInfoRepository->find($this->editClosingRemarksCourseInfoCommand->getId());
        }catch (\Exception $e){
            throw $e;
        }
        if(is_null($courseInfo)){
            throw new CourseInfoNotFoundException(sprintf('CourseInfo with id %s not found.', $this->editClosingRemarksCourseInfoCommand->getId()));
        }
        try{
            $courseInfo = $this->editClosingRemarksCourseInfoCommand->filledEntity($courseInfo);
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