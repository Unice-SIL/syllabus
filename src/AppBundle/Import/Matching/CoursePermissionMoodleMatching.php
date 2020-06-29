<?php


namespace AppBundle\Import\Matching;


use AppBundle\Constant\Permission;
use AppBundle\Entity\Course;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\User;
use AppBundle\Helper\Report\Report;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CourseManager;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;

class CoursePermissionMoodleMatching extends AbstractMatching implements MatchingInterface
{
    /**
     * @var CoursePermissionManager
     */
    private $coursePermissionManager;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var CourseInfoManager
     */
    private $courseInfoManager;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var CourseManager
     */
    private $courseManager;

    /**
     * CoursePermissionMoodleMatching constructor.
     * @param CoursePermissionManager $coursePermissionManager
     * @param EntityManagerInterface $em
     * @param CourseInfoManager $courseInfoManager
     * @param UserManager $userManager
     * @param CourseManager $courseManager
     */
    public function __construct(
        CoursePermissionManager $coursePermissionManager,
        EntityManagerInterface $em,
        CourseInfoManager $courseInfoManager,
        UserManager $userManager,
        CourseManager $courseManager
    )
    {
        $this->coursePermissionManager = $coursePermissionManager;
        $this->em = $em;
        $this->courseInfoManager = $courseInfoManager;
        $this->userManager = $userManager;
        $this->courseManager = $courseManager;
    }


    public function getNewEntity(): object
    {
        $coursePermission = $this->coursePermissionManager->new();
        $coursePermission->setPermission(Permission::WRITE);
        return $coursePermission;
    }

    public function getLineIds(): array
    {
        return ['code', 'username'];
    }

    /**
     * @param CoursePermission $entity
     * @param string $property
     * @param string $name
     * @param string $type
     * @param $data
     * @param ReportLine $reportLine
     * @param Report $report
     * @return bool
     * @throws \Exception
     */
    public function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool
    {
        switch ($property) {
            case 'courseInfo':
                $course = $this->courseManager->new();
                $course->setCode($data);

                $courseInfo = $this->courseInfoManager->new();
                $courseInfo->setCourse($course);

                $entity->setCourseInfo($courseInfo);

                return false;

            case 'user':

                $user = $this->userManager->new();
                $user->setUsername($data)
                    ->setFirstname('')
                    ->setLastname('')
                    ->setEmail('');
                $entity->setUser($user);

                return false;

            case 'lastname':
                if($entity->getUser() instanceof User)
                {
                    $entity->getUser()->setLastname($data);
                }
                return false;

            case 'firstname':
                if($entity->getUser() instanceof User)
                {
                    $entity->getUser()->setFirstname($data);
                }
                return false;

            case 'email':
                if($entity->getUser() instanceof User)
                {
                    $entity->getUser()->setEmail($data);
                }
                return false;

        }

        return true;
    }


    protected function getBaseMatching(): array
    {
        return [
            'courseInfo' => ['name' => 'code', 'required' => true, 'type'=> 'string', 'description' => "Code du cours concerné par la permission"],
            'user' => ['name' => 'username', 'required' => true, 'type'=> 'string', 'description' => "Nom d'utilisateur concerné par la permission"],
            'lastname' => ['name' => 'lastname', 'required' => false, 'type' => 'string', 'description' => "Nom de famille de l'utilisateur concerné"],
            'firstname' => ['name' => 'firstname', 'required' => false, 'type' => 'string', 'description' => "Prénom de l'utilisateur concerné"],
            'email' => ['name' => 'email', 'required' => false, 'type' => 'string', 'description' => "Email de l'utilisateur concerné"]
        ];
    }
}