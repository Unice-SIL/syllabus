<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class CriticalAchievementControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CriticalAchievementControllerTest extends AbstractAdminControllerTest
{
    public function testCriticalAchievementListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCriticalAchievementListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_CRITICAL_ACHIEVEMENT_LIST);
        $this->assertResponseIsSuccessful();
    }
}