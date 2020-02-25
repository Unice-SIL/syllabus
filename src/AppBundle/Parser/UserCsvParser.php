<?php


namespace AppBundle\Parser;

use AppBundle\Entity\User;
use AppBundle\Helper\Report\ReportLine;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Manager\UserManager;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserCsvParser extends AbstractCsvParser implements ParserInterface
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * CoursePermissionCsvParser constructor.
     * @param EntityManagerInterface $em
     * @param UserManager $userManager
     */
    public function __construct(
        EntityManagerInterface $em,
        UserManager $userManager
    )
    {
        parent::__construct($em);
        $this->userManager = $userManager;
    }

    protected function getNewEntity(): object
    {
        return $this->userManager->create();
    }

    protected function getBaseMatching(): array
    {
        return [
            'username',
            'lastname',
            'firstname',
            'email',
        ];
    }

    protected function getLineIds(): array
    {
        return ['email'];
    }

    protected function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine): bool
    {
        //feel free to add some special case
        //...

        //if return true, the (parent) parse function keepGoing after manageSpecialCase call
        return true;
    }


}