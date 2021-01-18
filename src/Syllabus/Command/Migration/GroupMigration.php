<?php


namespace App\Syllabus\Command\Migration;


use App\Syllabus\Constant\UserRole;
use App\Syllabus\Entity\Groups;
use App\Syllabus\Entity\User;

/**
 * Class GroupMigration
 * @package AppBundle\Command\Migration
 */
class GroupMigration extends AbstractReferentialMigration
{

    protected static $defaultName = 'app:group-migration';

    /**
     * @return string
     */
    protected function getStartMessage(): string
    {
        return 'Start of groups creation';
    }

    /**
     * @return string
     */
    protected function getEndMessage(): string
    {
        return 'End of groups creation';
    }

    /**
     * @inheritDoc
     */
    protected function getEntityClassName(): string
    {
        return Groups::class;
    }

    /**
     * @return array
     */
    protected function getFindByFields(): array
    {
        return ['label'];
    }

    /**
     * @inheritDoc
     */
    protected function getEntities(): array
    {
        $superAdmins = ['casazza@unice.fr', 'ssaioud@unice.fr'];

        $groups = [];

        $group = new Groups();
        $group->setLabel('Super Administrateur')
            ->setRoles(UserRole::ROLES);

        foreach ($superAdmins as $superAdmin)
        {
            $user = $this->em->getRepository(User::class)->findOneBy(['username' => $superAdmin]);
            if($user instanceof User)
            {
                $group->addUser($user);
            }
        }

        $groups[] = $group;

        return $groups;
    }

}