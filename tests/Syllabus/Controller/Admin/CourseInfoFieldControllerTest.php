<?php


namespace Tests\Syllabus\Controller\Admin;

use Tests\WebTestCase;

/**
 * Class CourseInfoFieldControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseInfoFieldControllerTest extends WebTestCase
{
    public function testCourseInfoFieldListUserNotAuthenticated()
    {
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_FIELD_LIST));
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseInfoFieldListRedirectWithAdminPermission()
    {
        $this->login();
        $this->client()->request('GET', $this->generateUrl(self::ROUTE_ADMIN_COURSE_INFO_FIELD_LIST));
        $this->assertResponseIsSuccessful();
    }
}