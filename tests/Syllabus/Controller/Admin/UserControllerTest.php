<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class UserControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class UserControllerTest extends AbstractAdminControllerTest
{
    public function testUserListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_USER_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testUserListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_USER_LIST);
        $this->assertResponseIsSuccessful();
    }

}