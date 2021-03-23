<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class JobControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class JobControllerTest extends AbstractAdminControllerTest
{
    public function testJobListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_JOB_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testJobListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_JOB_LIST);
        $this->assertResponseIsSuccessful();
    }
}