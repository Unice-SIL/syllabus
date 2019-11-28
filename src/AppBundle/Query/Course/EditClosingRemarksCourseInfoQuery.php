<?php

namespace AppBundle\Query\Course;

use AppBundle\Command\Course\EditClosingRemarksCourseInfoCommand;
use AppBundle\Entity\CourseInfo;
use AppBundle\Exception\CourseInfoNotFoundException;
use AppBundle\Query\QueryInterface;
use AppBundle\Repository\CourseInfoRepositoryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class EditClosingRemarksCourseInfoQuery
 * @package AppBundle\Query\Course
 */
class EditClosingRemarksCourseInfoQuery
{

    /**
     * @var CourseInfoRepositoryInterface
     */
    private $courseInfoRepository;

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
     * @param CourseInfo $courseInfo
     * @throws \Exception
     */
    public function execute(CourseInfo $courseInfo): void
    {
        try{
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