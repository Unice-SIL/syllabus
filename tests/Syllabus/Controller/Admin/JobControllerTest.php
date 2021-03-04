<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class JobControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class JobControllerTest extends WebTestCase
{
    public function testJobListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_JOB_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testJobListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_JOB_LIST));
        $this->assertResponseIsSuccessful();
    }
}