<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class DomainControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class DomainControllerTest extends WebTestCase
{
    public function testDomainListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDomainListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DOMAIN_LIST));
        $this->assertResponseIsSuccessful();
    }
}