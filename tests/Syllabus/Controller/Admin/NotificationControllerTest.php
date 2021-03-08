<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class NotificationControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class NotificationControllerTest extends AbstractAdminControllerTest
{
    public function testNotificationListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_NOTIFICATION_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testNotificationListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_NOTIFICATION_LIST);
        $this->assertResponseIsSuccessful();
    }

}