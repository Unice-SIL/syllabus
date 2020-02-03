<?php


namespace AppBundle\Security\Voter;


use AppBundle\Constant\Permission;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CourseInfoVoter extends Voter
{

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }


    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, Permission::PERMISSIONS)) {
            return false;
        }

        if (!$subject instanceof CourseInfo) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        /** @var CourseInfo $courseInfo */
        $courseInfo = $subject;

        if ($this->decisionManager->decide($token, ['ROLE_ADMIN']))
        {
            return true;
        }
        /** @var CoursePermission $coursePermission */
        foreach ($courseInfo->getCoursePermissions() as $coursePermission)
        {
            if($coursePermission->getUser()->getId() === $user->getId() && $coursePermission->getPermission() === $attribute)
            {
                return true;
            }
        }
        return false;

    }
}