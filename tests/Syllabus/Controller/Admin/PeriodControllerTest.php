<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class PeriodControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class PeriodControllerTest extends WebTestCase
{
    public function testPeriodListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testPeriodListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_PERIOD_LIST));
        $this->assertResponseIsSuccessful();
    }

}