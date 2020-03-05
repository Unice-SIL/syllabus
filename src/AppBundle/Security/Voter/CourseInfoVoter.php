<?php


namespace AppBundle\Security\Voter;


use AppBundle\Constant\Permission;
use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePermission;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

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
        $class = [
            CourseAchievement::class,
            CourseInfo::class,
            CoursePrerequisite::class,
            CourseTutoringResource::class
        ];
        if (!in_array(get_class($subject), $class)) {
            return false;
        }
        if (!in_array($attribute, Permission::PERMISSIONS)) {
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

        switch (get_class($subject)) {
            case CourseInfo::class:
                return $this->getPermission($subject, $user, $attribute);
                break;
            case CourseAchievement::class:
                $courseInfo = $subject->getCourseInfo();
                return $this->getPermission($courseInfo, $user, $attribute);
                break;
            case CoursePrerequisite::class:
                $courseInfo = $subject->getCourseInfo();
                return $this->getPermission($courseInfo, $user, $attribute);
                break;
            case CourseTutoringResource::class:
                $courseInfo = $subject->getCourseInfo();
                return $this->getPermission($courseInfo, $user, $attribute);
                break;
        }

        // A voir si on le met avant, je le mets ici pour test les classes //
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }
        // end //

        return false;
    }

    private function getPermission(CourseInfo $couseInfo, User $user, $attribute){
        foreach ($couseInfo->getCoursePermissions() as $coursePermission) {
            if ($coursePermission->getUser()->getId() === $user->getId() && $coursePermission->getPermission() === $attribute) {
                return true;
            }
        }
        return false;
    }
}