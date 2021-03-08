<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class LanguageControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class LanguageControllerTest extends AbstractAdminControllerTest
{
    public function testLanguageListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LANGUAGE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLanguageListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LANGUAGE_LIST);
        $this->assertResponseIsSuccessful();
    }

}