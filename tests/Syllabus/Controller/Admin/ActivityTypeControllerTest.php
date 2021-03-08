<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class ActivityTypeControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ActivityTypeControllerTest extends AbstractAdminControllerTest
{
    public function testActivityTypeListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testActivityTypeListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_ACTIVITY_TYPE_LIST);
        $this->assertResponseIsSuccessful();
    }
}