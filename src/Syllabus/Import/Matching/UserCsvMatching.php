<?php


namespace App\Syllabus\Import\Matching;

use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Manager\UserManager;

class UserCsvMatching extends AbstractMatching implements MatchingInterface
{
    /**
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * CoursePermissionCsvParser constructor.
     * @param UserManager $userManager
     */
    public function __construct(
        UserManager $userManager
    )
    {
        $this->userManager = $userManager;
    }

    public function getNewEntity(): object
    {
        return $this->userManager->new();
    }

    public function getBaseMatching(): array
    {
        return [
            'username' => ['required' => true, 'description' => "Login/identifiant de l'utilisateur"],
            'lastname' => ['required' => true, 'description' => "Nom de l'utilisateur"],
            'firstname' => ['required' => true, 'description' => "Prénom de l'utilisateur"],
            'email' => ['required' => true, 'description' => "Adresse mail de l'utilisateur"],
        ];
    }

    public function getLineIds(): array
    {
        return ['username', 'lastname', 'firstname'];
    }

    public function manageSpecialCase($entity, string $property, string $name, string $type, $data, ReportLine $reportLine, Report $report): bool
    {
        //feel free to add some special case
        //...

        //if return true, the (parent) parse function keepGoing after manageSpecialCase call
        return true;
    }


}