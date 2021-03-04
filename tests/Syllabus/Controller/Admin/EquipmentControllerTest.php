<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class EquipmentControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class EquipmentControllerTest extends WebTestCase
{
    public function testEquipmentListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testEquipmentListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_EQUIPMENT_LIST));
        $this->assertResponseIsSuccessful();
    }
}