<?php


namespace AppBundle\Manager;


use AppBundle\Entity\CoursePermission;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CoursePermissionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return CoursePermission
     * @throws \Exception
     */
    public function create()
    {
        $coursePermission = new CoursePermission();

        $coursePermission->setId(Uuid::uuid4());

        return $coursePermission;
    }

}