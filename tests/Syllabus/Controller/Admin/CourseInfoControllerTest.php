<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class CourseInfoControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseInfoControllerTest extends WebTestCase
{
    public function testCourseInfoListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseInfoListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_LIST));
        $this->assertResponseIsSuccessful();
    }
}