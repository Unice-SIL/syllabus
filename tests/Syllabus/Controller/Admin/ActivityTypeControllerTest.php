<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class ActivityTypeControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityTypeControllerTest extends WebTestCase
{
    public function testActivityTypeListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityTypeListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST));
        $this->assertResponseIsSuccessful();
    }
}