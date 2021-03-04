<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class CriticalAchievementControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CriticalAchievementControllerTest extends WebTestCase
{
    public function testCriticalAchievementListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCriticalAchievementListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST));
        $this->assertResponseIsSuccessful();
    }
}