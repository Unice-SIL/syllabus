<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class CourseControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseControllerTest extends AbstractAdminControllerTest
{
    public function testCourseListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_LIST);
        $this->assertResponseIsSuccessful();
    }
}