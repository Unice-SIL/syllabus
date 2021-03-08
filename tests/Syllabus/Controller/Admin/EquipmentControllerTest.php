<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class EquipmentControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class EquipmentControllerTest extends AbstractAdminControllerTest
{
    public function testEquipmentListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_EQUIPMENT_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testEquipmentListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_EQUIPMENT_LIST);
        $this->assertResponseIsSuccessful();
    }
}