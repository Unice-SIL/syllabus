<?php


namespace Tests\Syllabus\Controller\Admin;

use App\Syllabus\Exception\UserNotFoundException;
use App\Syllabus\Exception\YearNotFoundException;

/**
 * Class DashboardControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class DashboardControllerTest extends AbstractAdminControllerTest
{
    public function testDashboardUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_DASHBOARD);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testDashboardWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_DASHBOARD);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @throws UserNotFoundException
     * @throws YearNotFoundException
     */
    public function testYearFilter()
    {
        $this->login();
        $crawler = $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_DASHBOARD));

        $this->submitForm($crawler->filter('button[type="submit"]'), 'dashboard',
        [
                'years' => $this->getYear()->getId()
        ]);

        $this->assertResponseIsSuccessful();
    }

}