<?php


namespace Tests\Syllabus\Controller\CourseInfo;


use App\Syllabus\Exception\CourseNotFoundException;
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
}