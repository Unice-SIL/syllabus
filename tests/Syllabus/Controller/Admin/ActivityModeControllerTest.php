<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class ActivityModeControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityModeControllerTest extends AbstractAdminControllerTest
{
    public function testActivityModeListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityModeListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_MODE_LIST);
        $this->assertResponseIsSuccessful();
    }
}