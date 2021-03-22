<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Entity\CourseAchievement;
use App\Syllabus\Entity\CriticalAchievement;
use App\Syllabus\Entity\Equipment;
use App\Syllabus\Exception\CourseAchievementNotFoundException;
use App\Syllabus\Exception\CourseNotFoundException;
use App\Syllabus\Exception\CriticalAchievementNotFoundException;
use App\Syllabus\Exception\EquipmentNotFoundException;
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
        $course = $this->getCourse(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl($route, ['id' => $course->getId()]));
    }

    /**
     * @param $route
     * @throws CourseNotFoundException
     */
    public function tryRedirectWithAdminPermission($route)
    {
        $this->login();
        $course = $this->getCourse(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl($route, ['id' => $course->getId()]));
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
        $course = $this->getCourse(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
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
        $course = $this->getCourse(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
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
     * @return CriticalAchievement
     * @throws CriticalAchievementNotFoundException
     */
    public function getCriticalAchievement()
    {
        $criticalAchievement = null;
        if (!$criticalAchievement instanceof CriticalAchievement)
        {
            $criticalAchievement = current($this->getEntityManager()->getRepository(CriticalAchievement::class)->findAll());
        }

        if (!$criticalAchievement instanceof CourseAchievement)
        {
            throw new CriticalAchievementNotFoundException();
        }

        return $criticalAchievement;
    }

    /**
     * @return Equipment
     * @throws EquipmentNotFoundException
     */
    public function getEquipment()
    {
        $equipment = null;
        if (!$equipment instanceof Equipment)
        {
            $equipment = current($this->getEntityManager()->getRepository(Equipment::class)->findAll());
        }

        if (!$equipment instanceof Equipment)
        {
            throw new EquipmentNotFoundException();
        }

        return $equipment;
    }
}