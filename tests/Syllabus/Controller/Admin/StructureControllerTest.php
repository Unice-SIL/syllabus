<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class StructureControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class StructureControllerTest extends AbstractAdminControllerTest
{
    public function testStructureListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_STRUCTURE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testStructureListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_STRUCTURE_LIST);
        $this->assertResponseIsSuccessful();
    }

}