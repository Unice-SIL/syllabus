<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class NotificationControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class NotificationControllerTest extends WebTestCase
{
    public function testNotificationListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_NOTIFICATION_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testNotificationListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_NOTIFICATION_LIST));
        $this->assertResponseIsSuccessful();
    }

}