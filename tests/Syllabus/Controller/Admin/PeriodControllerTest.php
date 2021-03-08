<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class PeriodControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class PeriodControllerTest extends AbstractAdminControllerTest
{
    public function testPeriodListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_PERIOD_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testPeriodListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_PERIOD_LIST);
        $this->assertResponseIsSuccessful();
    }

}