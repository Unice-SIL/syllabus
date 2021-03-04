<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class GroupsControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class GroupsControllerTest extends WebTestCase
{
    public function testGroupsListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testGroupsListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_GROUPS_LIST));
        $this->assertResponseIsSuccessful();
    }
}