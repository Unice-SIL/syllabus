<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class GroupsControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class GroupsControllerTest extends AbstractAdminControllerTest
{
    public function testGroupsListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_GROUPS_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testGroupsListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_GROUPS_LIST);
        $this->assertResponseIsSuccessful();
    }
}