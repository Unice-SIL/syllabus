<?php


namespace Tests\Syllabus\Controller\Admin;

/**
 * Class CourseInfoControllerTest
 * @package Tests\Syllabus\Controller\Admin
 */
class CourseInfoControllerTest extends AbstractAdminControllerTest
{
    public function testCourseInfoListUserNotAuthenticated()
    {
        $this->tryUserNotAuthenticate(self::ROUTE_ADMIN_COURSE_INFO_LIST);
        $this->assertResponseRedirects();
        $this->assertStringContainsString('/Shibboleth.sso', $this->client()->getResponse()->getContent());
    }

    public function testCourseInfoListWithAdminPermission()
    {
        $this->tryWithAdminPermission(self::ROUTE_ADMIN_COURSE_INFO_LIST);
        $this->assertResponseIsSuccessful();
    }
}