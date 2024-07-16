<?php


namespace App\Syllabus\Security\Voter;


use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Entity\CourseCriticalAchievement;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CoursePrerequisite;
use App\Syllabus\Entity\CourseResourceEquipment;
use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Entity\CourseSectionActivity;
use App\Syllabus\Entity\CourseTeacher;
use App\Syllabus\Entity\CourseTutoringResource;
use App\Syllabus\Entity\LearningAchievement;
use App\Syllabus\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class CourseInfoVoter
 * @package App\Syllabus\Security\Voter
 */
class CourseInfoVoter extends Voter
{
    /**
     * @var AccessDecisionManagerInterface
     */
    private AccessDecisionManagerInterface $decisionManager;

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
    protected function supports(string $attribute, mixed $subject): bool
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
            CourseSectionActivity::class,
            CourseResourceEquipment::class
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
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN_COURSE_INFO_UPDATE'])) {
            return true;
        }

        /** @var User $user */
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        if($subject instanceof CourseInfo)
        {
            return $this->getPermission($subject, $user, $attribute);
        }

        if($subject instanceof LearningAchievement)
        {
            $courseInfo = $subject->getCourseCriticalAchievement()->getCourseInfo();
            return $this->getPermission($courseInfo, $user, $attribute);
        }

        if(
            $subject instanceof CourseAchievement or
            $subject instanceof CourseTeacher or
            $subject instanceof CoursePrerequisite or
            $subject instanceof CourseSection or
            $subject instanceof CourseCriticalAchievement or
            $subject instanceof CourseTutoringResource or
            $subject instanceof CourseResourceEquipment
        )
        {
            $courseInfo = $subject->getCourseInfo();
            return $this->getPermission($courseInfo, $user, $attribute);
        }

        if($subject instanceof CourseSectionActivity)
        {
            $courseInfo = $subject->getCourseSection()->getCourseInfo();
            return $this->getPermission($courseInfo, $user, $attribute);
        }

        return false;
    }

    /**
     * @param CourseInfo $courseInfo
     * @param User $user
     * @param $attribute
     * @return bool
     */
    private function getPermission(CourseInfo $courseInfo, User $user, $attribute): bool
    {
        foreach ($courseInfo->getCoursePermissions() as $coursePermission) {
            if ($coursePermission->getUser()->getId() === $user->getId() && $coursePermission->getPermission() === $attribute) {
                return true;
            }
        }
        return false;
    }
}