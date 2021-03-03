<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class ActivityModeControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityModeControllerTest extends WebTestCase
{
    public function testActivityModeListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityModeListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST));
        $this->assertResponseIsSuccessful();
    }
}