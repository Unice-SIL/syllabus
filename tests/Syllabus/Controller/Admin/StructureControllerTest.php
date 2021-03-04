<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class StructureControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class StructureControllerTest extends WebTestCase
{
    public function testStructureListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testStructureListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_STRUCTURE_LIST));
        $this->assertResponseIsSuccessful();
    }

}