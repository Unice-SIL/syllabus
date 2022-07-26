<?php


namespace Tests\Syllabus\Controller;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Entity\CoursePermission;
use App\Syllabus\Exception\CourseNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Tests\WebTestCase;

/**
 * Class DefaultControllerTest
 * @package Tests\Syllabus\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    public function testHomepageUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_HOMEPAGE));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testHomepage()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_HOMEPAGE));
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testRouterRedirectWithAdminPermission()
    {
        $this->login();
        $course = $this->getCourseInfo(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ROUTER, [
            'code' => $course->getCourse()->getCode(),
            'year' => $course->getYear()->getId()
        ]));

        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD, ['id' => $course->getId()]));

        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ROUTER, [
            'code' => $course->getCourse()->getCode()
        ]));
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testRouterRedirectWithPermission()
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $courseInfo = $this->getCourseInfo(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);

        /** @var CoursePermission $coursePermission */
        $coursePermission = new CoursePermission();
        $coursePermission->setUser($user)->setCourseInfo($courseInfo)->setPermission(Permission::WRITE);

        $this->getEntityManager()->persist($coursePermission);
        $this->getEntityManager()->flush();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ROUTER, [
            'code' => $courseInfo->getCourse()->getCode(),
            'year' => $courseInfo->getYear()->getId()
        ]));
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_COURSE_INFO_DASHBOARD, ['id' => $courseInfo->getId()]));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testRouterWithoutPermission()
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER'])
            ->setGroups(new ArrayCollection());
        $this->getEntityManager()->flush();
        $this->login($user);
        $course = $this->getCourseInfo(self::COURSE_NOT_ALLOWED_CODE, self::COURSE_NOT_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ROUTER, [
            'code' => $course->getCourse()->getCode(),
            'year' => $course->getYear()->getId()
        ]));
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_COURSE_STUDENT_VIEW, ['id' => $course->getId()]));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testLightRouterUserNotAuthenticate()
    {
        $course = $this->getCourseInfo(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ROUTER_LIGHT, [
            'code' => $course->getCourse()->getCode(),
            'year' => $course->getYear()->getId()
        ]));
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_COURSE_LIGHT_VIEW, ['id' => $course->getId()]));
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testLightRouterUserAuthenticate()
    {
        $this->login();
        $course = $this->getCourseInfo(self::COURSE_ALLOWED_CODE, self::COURSE_ALLOWED_YEAR);
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ROUTER_LIGHT, [
            'code' => $course->getCourse()->getCode(),
            'year' => $course->getYear()->getId()
        ]));
        $this->assertResponseRedirects($this->generateUrl(self::ROUTE_APP_ROUTER, [
            'code' => $course->getCourse()->getCode(),
            'year' => $course->getYear()->getId()
        ]));

        $this->client()->request('GET', $this->generateUrl(self::ROUTE_APP_ROUTER_LIGHT, [
            'code' => $course->getCourse()->getCode(),
        ]));
       $this->assertResponseIsSuccessful();
    }

    public function testCreditsUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_CREDITS));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCreditsSuccessful()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_CREDITS));
        $this->assertResponseIsSuccessful();
    }
}