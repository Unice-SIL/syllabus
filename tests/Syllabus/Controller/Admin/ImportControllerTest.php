<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class ImportControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class ImportControllerTest extends AbstractAdminControllerTest
{
    public function testImportCourseInfoUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_IMPORT_COURSE_INFO);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testImportCourseInfoWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_IMPORT_COURSE_INFO);
        $this->assertResponseIsSuccessful();
    }

    public function testImportPermissionUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_IMPORT_PERMISSION);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testImportPermissionWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_IMPORT_PERMISSION);
        $this->assertResponseIsSuccessful();
    }

    public function testImportUserUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_IMPORT_USER);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testImportUserWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_IMPORT_USER);
        $this->assertResponseIsSuccessful();
    }

}