<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class YearControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class YearControllerTest extends AbstractAdminControllerTest
{
    public function testYearListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_YEAR_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testYearListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_YEAR_LIST);
        $this->assertResponseIsSuccessful();
    }

}