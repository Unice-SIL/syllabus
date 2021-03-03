<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class CampusControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CampusControllerTest extends WebTestCase
{
    public function testCampusListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCampusListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CAMPUS_LIST));
        $this->assertResponseIsSuccessful();
    }
}