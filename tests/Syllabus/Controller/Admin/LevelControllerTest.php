<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class LevelControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class LevelControllerTest extends WebTestCase
{
    public function testLevelListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLevelListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LEVEL_LIST));
        $this->assertResponseIsSuccessful();
    }

}