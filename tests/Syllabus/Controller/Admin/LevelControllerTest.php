<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class LevelControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class LevelControllerTest extends AbstractAdminControllerTest
{
    public function testLevelListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_LEVEL_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testLevelListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_LEVEL_LIST);
        $this->assertResponseIsSuccessful();
    }

}