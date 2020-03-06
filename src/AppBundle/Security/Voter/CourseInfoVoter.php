<?php


namespace AppBundle\Security\Voter;


use AppBundle\Constant\Permission;
use AppBundle\Entity\CourseAchievement;
use AppBundle\Entity\CourseCriticalAchievement;
use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CoursePrerequisite;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Entity\CourseTutoringResource;
use AppBundle\Entity\CriticalAchievement;
use AppBundle\Entity\LearningAchievement;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use function League\Csv\is_nullable_int;

/**
 * Class CourseInfoVoter
 * @package AppBundle\Security\Voter
 */
class CourseInfoVoter extends Voter
{
    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * CourseInfoVoter constructor.
     * @param AccessDecisionManagerInterface $decisionManager
     */
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
        $classes = [
            CourseAchievement::class,
            CourseInfo::class,
            CoursePrerequisite::class,
            CourseTutoringResource::class,
            CourseTeacher::class,
            LearningAchievement::class,
            CourseCriticalAchievement::class,
            CourseSection::class,
        ];
        if (is_null($subject)) {
            return false;
        }
        if (!in_array($attribute, Permission::PERMISSIONS)) {
            return false;
        }
        foreach ($classes as $class)
        {
            if (is_a($subject, $class))
                return true;
        }
        return false;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        /** @var User $user */
        $user = $token->getUser();

        switch (get_class($subject)) {
            case CourseInfo::class:
                return $this->getPermission($subject, $user, $attribute);
                break;
            case LearningAchievement::class:
                $courseInfo = $subject->getCourseCriticalAchievement()->getCourseInfo();
                return $this->getPermission($courseInfo, $user, $attribute);
                break;
            case CourseAchievement::class:
            case CourseTeacher::class:
            case CoursePrerequisite::class:
            case CourseSection::class:
            case CourseCriticalAchievement::class:
            case CourseTutoringResource::class:
                $courseInfo = $subject->getCourseInfo();
                return $this->getPermission($courseInfo, $user, $attribute);
                break;
        }

        return false;
    }

    /**
     * @param CourseInfo $couseInfo
     * @param User $user
     * @param $attribute
     * @return bool
     */
    private function getPermission(CourseInfo $couseInfo, User $user, $attribute)
    {
        foreach ($couseInfo->getCoursePermissions() as $coursePermission) {
            if ($coursePermission->getUser()->getId() === $user->getId() && $coursePermission->getPermission() === $attribute) {
                return true;
            }
        }
        return false;
    }
}