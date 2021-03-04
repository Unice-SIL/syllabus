<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class LanguageControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class LanguageControllerTest extends WebTestCase
{
    public function testLanguageListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLanguageListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_LANGUAGE_LIST));
        $this->assertResponseIsSuccessful();
    }

}