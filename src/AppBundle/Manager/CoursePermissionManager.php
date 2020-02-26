<?php


namespace AppBundle\Manager;


use AppBundle\Entity\CoursePermission;
use AppBundle\Helper\ErrorManager;
use AppBundle\Helper\Report\ReportingHelper;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CoursePermissionManager extends AbstractManager
{

    /**
     * CoursePermissionManager constructor.
     * @param EntityManagerInterface $em
     * @param ErrorManager $errorManager
     */
    public function __construct(EntityManagerInterface $em, ErrorManager $errorManager)
    {
        parent::__construct($em, $errorManager);
    }

    /**
     * @return CoursePermission
     * @throws \Exception
     */
    public function create(): CoursePermission
    {
        return new CoursePermission();
    }

    protected function getClass(): string
    {
        return CoursePermission::class;
    }

}