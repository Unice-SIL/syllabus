<?php

namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Entity\CourseSection;
use App\Syllabus\Exception\CourseAchievementNotFoundException;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\CourseSectionNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Tests\WebTestCase;

abstract class AbstractCourseInfoControllerTest extends WebTestCase
{
    /**
     * @param $route
     * @throws CourseNotFoundException
     */
    public function tryUserNotAuthenticated($route)
    {
        $course = $this->getCourseInfo(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl($route, ['id' => $course->getId()]));
    }

    /**
     * @param $route
     * @throws CourseNotFoundException
     */
    public function tryRedirectWithAdminPermission($route)
    {
        $this->login();
        $course = $this->getCourseInfo(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl($route, ['id' => $course->getId()]));
    }

    /**
     * @param $route
     * @throws CourseNotFoundException
     */
    public function tryWithPermission($route, $permission)
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());

        /** @var CourseInfo $course */
        $courseInfo = $this->getCourseInfo(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);

        /** @var CoursePermission $coursePermission */
        $coursePermission = new CoursePermission();
        $coursePermission->setUser($user)->setCourseInfo($courseInfo)->setPermission($permission);

        $this->getEntityManager()->persist($coursePermission);
        $this->getEntityManager()->flush();
        $this->login($user);
        $this->client()->request('GET', $this->generateUrl($route, ['id' => $courseInfo->getId()]));
    }

    /**
     * @param $route
     * @throws CourseNotFoundException
     */
    public function tryRedirectWithPermission($route)
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $course = $this->getCourseInfo(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl($route, ['id' => $course->getId()]));
    }

    /**
     * @param $route
     * @throws CourseNotFoundException
     */
    public function tryWithoutPermission($route)
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $course = $this->getCourseInfo(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl($route, ['id' => $course->getId()]));
    }

    /**
     * @return CourseAchievement
     * @throws CourseAchievementNotFoundException
     */
    public function getCourseAchievement()
    {
        $courseAchievement = null;
        if (!$courseAchievement instanceof CourseAchievement)
        {
            $courseAchievement = current($this->getEntityManager()->getRepository(CourseAchievement::class)->findAll());
        }

        if (!$courseAchievement instanceof CourseAchievement)
        {
            throw new CourseAchievementNotFoundException();
        }

        return $courseAchievement;
    }

    /**
     * @return CourseSection
     * @throws CourseSectionNotFoundException
     */
    public function getCourseSection()
    {
        $courseSection = current($this->getEntityManager()->getRepository(CourseSection::class)->findAll());
        if (!$courseSection instanceof CourseSection)
        {
            throw new CourseSectionNotFoundException();
        }

        return $courseSection;
    }
}