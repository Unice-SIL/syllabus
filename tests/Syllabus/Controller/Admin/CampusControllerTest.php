<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class CampusControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CampusControllerTest extends AbstractAdminControllerTest
{
    public function testCampusListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CAMPUS_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCampusListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CAMPUS_LIST);
        $this->assertResponseIsSuccessful();
    }
}