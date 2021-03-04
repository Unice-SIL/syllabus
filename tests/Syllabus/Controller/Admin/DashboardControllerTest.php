<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class DashboardControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class DashboardControllerTest extends WebTestCase
{
    public function testDashboardUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DASHBOARD));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDashboardRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DASHBOARD));
        $this->assertResponseIsSuccessful();
    }
}