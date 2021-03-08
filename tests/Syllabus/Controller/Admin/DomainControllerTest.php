<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class DomainControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class DomainControllerTest extends AbstractAdminControllerTest
{
    public function testDomainListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_DOMAIN_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDomainListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DOMAIN_LIST);
        $this->assertResponseIsSuccessful();
    }
}