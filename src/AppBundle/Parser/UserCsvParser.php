<?php


namespace AppBundle\Parser;

use AppBundle\Helper\Report\ReportLine;
use AppBundle\Manager\UserManager;
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
            'username' => ['required' => true, 'description' => "Login/identifiant de l'utilisateur"],
            'lastname' => ['required' => true, 'description' => "Nom de l'utilisateur"],
            'firstname' => ['required' => true, 'description' => "Prénom de l'utilisateur"],
            'email' => ['required' => true, 'description' => "Adresse mail de l'utilisateur"],
        ];
    }

    protected function getLineIds(): array
    {
        return ['username', 'lastname', 'firstname'];
    }

    protected function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine): bool
    {
        //feel free to add some special case
        //...

        //if return true, the (parent) parse function keepGoing after manageSpecialCase call
        return true;
    }


}