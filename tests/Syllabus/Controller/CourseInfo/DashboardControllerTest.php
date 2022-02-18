<?php


namespace Tests\Syllabus\Controller\CourseInfo;

use App\Syllabus\Constant\Permission;
use App\Syllabus\Exception\CourseNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashboardControllerTest
 * @package Tests\Syllabus\Controller\CourseInfo
 */
class DashboardControllerTest extends AbstractCourseInfoControllerTest
{
    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticated(self::ROUTE_APP_DASHBOARD_INDEX);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardRedirectWithAdminPermission()
    {
        $this->tryRedirectWithAdminPermission(self::ROUTE_APP_DASHBOARD_INDEX);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardWithPermission()
    {
        $this->tryWithPermission(self::ROUTE_APP_DASHBOARD_INDEX, Permission::WRITE);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws CourseNotFoundException
     */
    public function testDashboardWithoutPermission()
    {
        $this->tryWithoutPermission(self::ROUTE_APP_DASHBOARD_INDEX);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}