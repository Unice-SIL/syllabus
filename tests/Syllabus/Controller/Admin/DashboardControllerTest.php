<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class DashboardControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class DashboardControllerTest extends AbstractAdminControllerTest
{
    public function testDashboardUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_DASHBOARD);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDashboardWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DASHBOARD);
        $this->assertResponseIsSuccessful();
    }
}